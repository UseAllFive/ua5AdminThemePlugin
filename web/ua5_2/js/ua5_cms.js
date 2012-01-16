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
          $field_row = $this.parents('tr'),
          $obj_row = $field_row.parents('tr'),
          id = $obj_row.find('input[name$="[id]"]').val();

      if ( confirm('Are you sure?') ) {
        $field_row.hide();

        $.post(
          ua5_cms.script_name+'/'+ ua5_cms.model_name +'/ajaxDelete'+ relationAlias,
          {
            'id': id
          },
          function(data) {
            if(data.success) {
              $field_row.remove();
            } else {
              alert('Unable to delete media: ' + data.error_msg);
              $obj_row.show();
            }
          }
        );
      }

      return false;
    });
  });
}


/*
ua5_cms = (function(window, document, $) {
  
  return {
  }
})(this, this.document, jQuery);
*/
