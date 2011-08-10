if ( !window.ua5_cms ) {
  window.ua5_cms = {}
}

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
ua5_cms.applySimpleTextEditor = function( $el ) {
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
  ua5_cms.ste[id].init();

  //-- Setup the onSubmit functionality
  $form.submit(function() {
    ua5_cms.ste[id].submit();
  });

  return $el;
}

/*
ua4_cms = (function(window, document, $) {
  
  return {
  }
})(this, this.document, jQuery);
*/
