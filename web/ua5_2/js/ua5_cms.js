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
    }
  };
})();


ua5_cms.createId = function( prefix ) {
  var id;
  if ( !prefix || prefix.match(/^[0-9]/) ) {
    prefix = 'id_' + prefix;
  }
  do {
    id = prefix + (new Date().getTime());
  } while( 0 !== $('#'+id).length );
  return id;
}


ua5_cms.applySimpleTextEditor = function( $el, options) {
  var $form = $el.closest('form'),
      id = $el.attr('id');

  //-- Make sure we have a ua5_cms.ste object
  if ( !ua5_cms.ste ) {
    ua5_cms.ste = [];
  }

  //-- If we don't have an ID already, assign one
  if ( !id ) {
    id = ua5_cms.createId();
    $el.attr('id', id);
  }
  ua5_cms.ste[id] = new SimpleTextEditor(id, "ua5_cms.ste['"+ id +"']");
  if ( options && options.styles ) {
    ua5_cms.ste[id].styles = options.styles;
  }
  ua5_cms.ste[id].init();

  //-- Setup the onSubmit functionality
  $form.submit(function() {
    ua5_cms.ste[id].submit();
  });

  return $el;
}


ua5_cms.deleteRelated = function(relationAlias) {
  $(function() {
    $('input[name*="'+ relationAlias + '"][name$="[delete]"]').click(function() {
      var $this = $(this),
          $field_row,
          $obj_row,
          id;

      if ( confirm('Are you sure?') ) {

        //-- Handle if we are in a table or list wrapper
        if ( 'TD' === $this.parent()[0].tagName ) {
          $field_row = $this.closest('tr');
          $obj_row = $field_row.parent().closest('tr');
        } else {
          $field_row = $this.closest('li');
          $obj_row = $field_row.parent().closest('tr');
        }

        id = parseInt($obj_row.find('input[name$="[id]"]').val(), 10);

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
  });
}

ua5_cms.namespace('form').chosen = (function() {

  var $chosen_fields,
      $date_fields,
      $upload_fields;


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
            'style':  'position: relative; cursor: pointer;'
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
          image_url = $this.attr('href'),
          image_tag = '<img width="475" src="'+image_url+'" />';
      $this.qtip({
        content: image_tag,
        show: 'mouseover',
        hide: 'mouseout',
        style: {
          name: 'light',
          tip: true,
          width: {
            min: 500,
            max: 500
          },
          border: {
            radius: 4,
            color: '#e1e1e1'
          }
        },
        position: {
          corner: {
            target: 'topMiddle',
            tooltip: 'bottomMiddle'
          }
        }
      });
    });
  }


  function init() {

    $chosen_fields = $('select');
    $date_fields = $('select[name$="[month]"],select[name$="[day]"],select[name$="[year]"]');
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

jQuery(function() {
  ua5_cms.form.chosen.init();
});
