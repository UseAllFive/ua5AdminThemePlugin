var ua5_cms = (function(){

  "use strict";

  var script_name = (window.location.pathname.match(/^(\/[^\/]*.php)?/)[1] || ''),
      model_name = (window.location.pathname.replace(script_name, '').split('/')[1] || '');

  return {
    // script name without trailing slash (caller always appends slash to this)
    'script_name': script_name,
    'model_name': model_name,

    'namespace': function(name) {
      if(this[name] === undefined) {
        this[name] = {};
      }

      if(typeof this[name] !== 'object') {
        throw "Namespace '"+name+"' was already defined and is not an Object";
      }

      return this[name];
    },

    'delegate': {}
  };
})();


ua5_cms.createId = function( prefix ) {
  var id;
  if ( !prefix || prefix.match(/^[0-9]/) ) {
    prefix = 'id_' + prefix;
  }
  do {
    id = prefix + (new Date().getTime());
  } while( !!document.getElementById(id) );
  return id;
};

ua5_cms.deleteRelated = (function() {
  var _added_relations = {};

  return function(relationAlias) {
    if ( _added_relations[relationAlias] ) {
      //-- Only bind once per relationAlias
      return false;
    }

    _added_relations[relationAlias] = true;

    $('input[name*="['+ relationAlias + ']"][name$="[delete]"]').click(function() {
      var $this = $(this),
          $field_row,
          $obj_row,
          $id,
          id;

      if ( confirm('Are you sure?') ) {

        //-- Handle if we are in a table or list wrapper
        if ( 'TD' === $this.parent()[0].tagName ) {
          $field_row = $this.closest('tr');
          $obj_row = $field_row.parent().closest('tr');
          id = $this.data('object-id');
          if ( !id ) {
            $id = $obj_row.find('td>table>tbody>tr>td>input[name$="[id]"]');
            id = parseInt($id.val(), 10);
          }
        } else {
          $field_row = $this.closest('li');
          $obj_row = $field_row.parent().closest('tr');
          id = $this.data('object-id');
          if ( !id ) {
            $id = $obj_row.find('td>ul>li>input[name$="[id]"]');
            id = parseInt($id.val(), 10);
          }
        }

        $this.prop('disabled', true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ua5_cms.script_name+'/'+ ua5_cms.model_name +'/ajaxDelete'+ relationAlias,
            data: {
              'id': id
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $this.prop('disabled', false);
            },
            success: function(data, textStatus, jqXHR) {
              var i,
                  matches,
                  prefix,
                  selector,
                  $els;

              if ( data.success ) {
                $obj_row.slideUp(1500, function() {
                  $(this).remove();
                });

                //-- Since we removed an object, if there are ones after this
                //   one, we need to fix their index's
                matches = $this.attr('name').match(/(.*)\[([0-9]+)\]/),
                prefix = matches[1],
                i = parseInt(matches[2], 10),
                selector = '[name^="'+ prefix +'['+ (1+i) +']"]';
                $els = $(selector);

                while ( 0 < $els.length ) {
                  $els.each(function() {
                    var cur_name = $(this).attr('name'),
                        new_name = cur_name.replace(
                          prefix +'['+ (1+i) +']',
                          prefix +'['+ (i) +']'
                        );
                    $(this).attr('name', new_name);
                  });
                  i += 1;
                  selector = '[name^="'+ prefix +'['+ (1+i) +']"]';
                  $els = $(selector);
                }

              } else {
                alert(
                  'Unable to delete media: ' + data.error_msg +"\n\n"+
                  'model_name: '+ ua5_cms.model_name +"\n"+
                  'relation_alias: '+ relationAlias +"\n"+
                  'id: '+ id
                );
                $field_row.show();
              }
            }
        });
      }

      return false;
    });
  };
})();

ua5_cms.namespace('form').chosen = (function() {

  var $chosen_fields,
      $date_fields,
      $upload_fields,
      date_fields_selector = [
        'select[name*="[date]"]',
        'select[name*="[month]"]',
        'select[name*="[day]"]',
        'select[name*="[year]"]'
      ].join(','),
      ignored_fields_selector = [
        date_fields_selector,
        '.double_list_select',
        '.double_list_select-selected'
      ].join(',');

  function applyChosen(opts) {
    if ( 'Object' !== typeof(opts) ) {
      opts = {};
    }
    $chosen_fields.chosen(opts);
  }


  function applyDateLabels() {
    $date_fields.each(function() {
      var $this = $(this),
          name = this.name.split('[').pop().replace(']', '');
      $this.attr('data-placeholder', name.substr(0,1).toUpperCase()+name.substr(1).toLowerCase());
      if ( 'month' === name ) {
        if ( $this.parents('.sf_admin_filter').length ) {
          $this.before('<br/>');
        }
      }
    });
  }


  function createCustomUpload() {
    $upload_fields.each(function() {

      var label,
          width,
          height,
          $parent,
          $input = $(this),
          $wrap = $('<div />', {
            'style':  'position: relative; cursor: pointer; overflow: hidden;'
          }),
          $after = $('<input />', {
            'type': 'button',
            'value': 'Upload',
            'style': 'position: absolute; left: 0; top: 0; z-index: 1'
          });

      $input
        .wrap($wrap)
        .after($after);
      width = $after.outerWidth();
      height = $after.outerHeight();
      $parent = $input.parent();

      $input.css({
        'opacity': 0,
        'z-index': 2,
        'position': 'absolute',
        'width': width,
        'height': height
      });
      $parent.css({
        'width': width,
        'height': height
      });

      $input.change(function() {
        $after.val('Upload '+$input.val().split('\\').pop());
        width = $after.outerWidth();
        $input.css('width', width);
        $parent.css('width', width);
      });

    });
  }


  function setViewButtons() {
    $view_fields.each(function() {
      var $this = $(this),
          src = $this.attr('href'),
          ext = src.split('.').pop(),
          width = 475,
          borderWidth = 5,
          outerWidth = width + borderWidth * 2,
          custom = { show: {}, hide: {} },
          tag;
      if ( /mpe?g|mov|mp(eg)?4/.test(ext) ) {
        tag = '<video width="'+width+'" src="'+src+'" controls autoplay>'+
          'Sorry, your browser doesn\'t support video playback.'+
          '</video>';
        custom.hide.fixed = true;
        custom.hide.when = { event: 'mouseout' };
      } else {
        tag = '<img width="'+width+'" src="'+src+'" />';
        custom.hide = 'mouseout';
      }
      $this.qtip($.extend({
        content: tag,
        show: {
          solo: true,
          when: { event: 'mouseover' }
        },
        style: {
          name: 'light',
          tip: true,
          width: {
            min: outerWidth,
            max: outerWidth
          },
          padding: 0,
          lineHeight: 0,
          boxSizing: 'border-box',
          border: {
            radius: borderWidth,
            color: '#e1e1e1'
          }
        },
        position: {
          corner: {
            target: 'topMiddle',
            tooltip: 'bottomMiddle'
          }
        }
      }, custom));
    });
  }


  function init() {

    if ( !$.fn.chosen ) {
      return false;
    }

    $chosen_fields = $('select').not(ignored_fields_selector);
    $date_fields = $(date_fields_selector);
    $upload_fields = $('input[type="file"]');
    $view_fields = $('a.view');

    //-- Add appropriate labels on date dropdowns
    applyDateLabels();

    //-- Make select fields use chosen plugin
    applyChosen({ allow_single_deselect: true });

    //-- Create custom upload fields
    createCustomUpload();

    //-- Enable the view button behavior
    setViewButtons();

  }
  return {
    'init': init
  };
})();

ua5_cms.sortable = (function() {

  "use strict";

  var delegate;

  function init(model, selector, opts) {
    opts = opts || {};
    var $list = $(selector);

    //-- Show handles
    //-- TODO: Not sure this is still getting used.
    $list.children('tr').children('th')
      .css({
        'display': 'block',
        'color': '#ffffff',
        'font-size': '0px',
        'padding-top': '16px'
      }).each(function() {
        $(this).append('<img src="/ua5AdminThemePlugin/images/sort.png" style="margin-top: -10px;" />');
      });

    $list.sortable($.extend({
      'axis': 'y',
      'cursor': 'move',
      'items' : opts.items_selector ? opts.items_selector : undefined,
      'update': function(e, ui) {

        //-- Don't cache the items so we can get the new order
        var $items = opts.items_selector ? $list.find(opts.items_selector) : $list.children('tr'),
            order = {};

        $items.each(function(i, el) {
          var $this = $(this),
              $position_input = $this.find('[name$="[position]"]'),
              id = opts.getItemId ? opts.getItemId($(el))
                   : ($this.data('id') || $this.children('th').text()),
              old_position = parseInt($position_input.val(), 10),
              new_position = (opts.use_nonzero_position || delegate.use_nonzero_position)
                             ? (i + 1) : i;
          order[id] = {
            'old_position': old_position,
            'new_position': new_position
          };
          $position_input.val(new_position);
        });

        $.ajax({
          url: ua5_cms.script_name + '/ua5Sort/sort',
          type: "POST",
          data: {
            'model': model,
            'order': order
          },
          dataType: "json"
        });
      }
    }, opts.sortable));
  }

  function style_sort_btns() {
    $('.sf_admin_action_promote a').button({
      icons: {
        primary: "ui-icon-triangle-1-n"
      },
      text: false
    });
    $('.sf_admin_action_demote a').button({
      icons: {
        primary: "ui-icon-triangle-1-s"
      },
      text: false
    });
  }

  delegate = ua5_cms.delegate.sortable = {
    use_nonzero_position: false
  };

  return {
    'init': init,
    'style_sort_btns': style_sort_btns
  };
})();

ua5_cms.wysiwyg = (function() {

  var _$fields;

  function _buildToolbar(opts) {

    var i,
        j,
        $inner,
        $toolbar_item,
        $toolbar = $('<div class="ua5-wysiwyg-toolbar clearfix" id="' + ua5_cms.createId('ua5_cms_wysiwyg_toolbar') + '"></div>'),
        $optional = $('<div class="ua5-wysiwyg-toolbar-options clearfix"></div>'),
        default_opts = {
          'toolbar': {

            'bold': {
              'tag': 'a',
              'icon': 'bold',
              'attrs': {
                'title': 'CTRL+B',
                'data-wysihtml5-command': 'bold'
              }
            },

            'italic': {
              'tag': 'a',
              'icon': 'italic',
              'attrs': {
                'title': 'CTRL+I',
                'data-wysihtml5-command': 'italic'
              }
            },

            'underline': {
              'tag': 'a',
              'icon': 'underline',
              'attrs': {
                'title': 'CTRL+U',
                'data-wysihtml5-command': 'underline'
              }
            },

            'leftAlign': {
              'tag': 'a',
              'icon': 'justify-left',
              'attrs': {
                'title': 'Left Align',
                'data-wysihtml5-command': 'justifyLeft'
              }
            },

            'centerAlign': {
              'tag': 'a',
              'icon': 'justify-center',
              'attrs': {
                'title': 'Center Align',
                'data-wysihtml5-command': 'justifyCenter'
              }
            },

            'rightAlign': {
              'tag': 'a',
              'icon': 'justify-right',
              'attrs': {
                'title': 'Right Align',
                'data-wysihtml5-command': 'justifyRight'
              }
            },

            'sup': {
              'tag': 'a',
              'icon': 'sup',
              'attrs': {
                'data-wysihtml5-command': 'superscript'
              }
            },

            'h1': {
              'tag': 'a',
              'icon': 'h1',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'formatBlock',
                'data-wysihtml5-command-value': 'h1'
              }
            },

            'h2': {
              'tag': 'a',
              'icon': 'h2',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'formatBlock',
                'data-wysihtml5-command-value': 'h2'
              }
            },

            'h3': {
              'tag': 'a',
              'icon': 'h3',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'formatBlock',
                'data-wysihtml5-command-value': 'h3'
              }
            },

            'ul': {
              'tag': 'a',
              'icon': 'unordered-list',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'insertUnorderedList'
              }
            },

            'ol': {
              'tag': 'a',
              'icon': 'ordered-list',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'insertOrderedList'
              }
            },

            'link': {
              'tag': 'a',
              'icon': 'link',
              'html': '<div data-wysihtml5-dialog="createLink" style="display: none;">' +
                      '  <label>' +
                      '    Link:' +
                      '    <input data-wysihtml5-dialog-field="href" value="http://">' +
                      '  </label>' +
                      '  <a class="btn" data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a class="btn" data-wysihtml5-dialog-action="cancel">Cancel</a>' +
                      '</div>',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'createLink'
              }
            },

            'image': {
              'tag': 'a',
              'icon': 'image',
              'html': '<div data-wysihtml5-dialog="insertImage" style="display: none;">' +
                      '  <label>' +
                      '    Image:' +
                      '    <input data-wysihtml5-dialog-field="src" value="http://">' +
                      '  </label>' +
                      '  <label>' +
                      '    Align:' +
                      '    <select data-wysihtml5-dialog-field="className">' +
                      '      <option value="">default</option>' +
                      '      <option value="wysiwyg-float-left">left</option>' +
                      '      <option value="wysiwyg-float-right">right</option>' +
                      '    </select>' +
                      '  </label>' +
                      '  <a class="btn" data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a class="btn" data-wysihtml5-dialog-action="cancel">Cancel</a>' +
                      '</div>',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'insertImage'
              }
            },

            'speech': {
              'tag': 'a',
              'icon': 'speech',
              'attrs': {
                'title': '',
                'data-wysihtml5-command': 'insertSpeech'
              }
            },

            'source': {
              'tag': 'a',
              'icon': 'source',
              'attrs': {
                'title': '',
                'data-wysihtml5-action': 'change_view'
              }
            },

            'separator': {
              'tag': 'span',
              'text': '',
              'attrs': {
                'class': 'separator'
              }
            }

          },

          enabled_items: [
            'bold', 'italic', 'underline', 'separator',
            'leftAlign', 'centerAlign', 'rightAlign', 'separator',
            'h1', 'h2', 'h3', 'separator',
            'ul', 'ol', 'separator',
            'link', 'image', 'separator',
            'speech', 'separator',
            'source'
          ]

        };

    opts = $.extend({}, default_opts, opts);

    for ( i in opts.enabled_items ) {
      if ( opts.toolbar.hasOwnProperty(opts.enabled_items[i]) ) {

        $toolbar_item = $('<'+opts.toolbar[opts.enabled_items[i]].tag+' class="btn" />');

        if ( opts.toolbar[opts.enabled_items[i]].hasOwnProperty('icon') ) {
          $toolbar_item.append('<i class="icon-'+opts.toolbar[opts.enabled_items[i]].icon+'" />');
        }

        if ( opts.toolbar[opts.enabled_items[i]].hasOwnProperty('text') ) {
          $toolbar_item.append($('<span />').text(opts.toolbar[opts.enabled_items[i]].text));
        }

        for ( j in opts.toolbar[opts.enabled_items[i]].attrs ) {
          $toolbar_item.attr(j, opts.toolbar[opts.enabled_items[i]].attrs[j]);
        }

        $toolbar.append($toolbar_item);

        if ( opts.toolbar[opts.enabled_items[i]].hasOwnProperty('html') ) {
          $optional.append(opts.toolbar[opts.enabled_items[i]].html);
        }

      }
    }

    $toolbar.append($optional);

    return $toolbar;

  }

  function _init() {

    var editor,
        $toolbar,
        $wrap,
        $this;

    if ( ! window.wysihtml5ParserRules ) {
      return false;
    }

    //-- Get the CMS fields
    _$fields = $('textarea').filter(':not(.noWYSIWYG)');

    //-- Override the default parser rules
    window.wysihtml5ParserRules.tags = $.extend({}, window.wysihtml5ParserRules.tags, {
      'b': {
        'rename_tag': 'strong'
      }
    });

    //-- Create the toolbar for each editor
    _$fields.each(function() {

      $this = $(this);
      $wrap = $('<div id="' + ua5_cms.createId('ua5_cms_wysiwyg_wrap') + '" />');
      $toolbar = _buildToolbar(window.wysihtml5ToolbarOptions||{});

      $this.wrap($wrap);
      $this.before($toolbar);

      editor = new wysihtml5.Editor($this.attr('id'), {
        toolbar: $toolbar.attr('id'),
        stylesheets: '/ua5AdminThemePlugin/ua5_2/css/wysiwyg.css',
        parserRules:  window.wysihtml5ParserRules
      });

    });

  }

  return {
    'init': _init
  };

})();

jQuery(function() {
  ua5_cms.wysiwyg.init();
  ua5_cms.form.chosen.init();
});
