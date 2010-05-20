/*

  Use All Five JS Classes

*/

var UA5 = { };

UA5.Filter = Class.$extend({

  __init__ : function($_sel) {
  
    this.filter = $_sel;
    
    if($($_sel)) {
    
      this.addToggle();
      $($_sel + ' form').hide();
      
    }
    
  },
  
  addToggle : function() {
  
    var toggle = $('<a/>').attr({ 'class' : 'ua5_admin_filter_toggle' }).html('Open Filter');
    
    $(this.filter).append(toggle);
  
  }

});

$(document).ready(function() {

  new UA5.Filter('.ua5_admin_filter');

});