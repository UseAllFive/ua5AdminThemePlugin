/*

  Use All Five JS Classes

*/

var UA5 = { };

UA5.Filter = Class.$extend({

  __init__ : function($_sel) {
  
    this.filter = $_sel;
    this.open = false;
    
    if($($_sel)) {
    
      this.addToggle();
      $($_sel + ' form').hide();
      
    }
    
  },
  
  addToggle : function() {
  
    var $self = this;
  
    var toggle = $('<a/>')
      .attr({ 'class' : 'ua5_admin_filter_toggle' })
      .html('Open Filter')
      .click(function(e){
      
        e.preventDefault();
    
        if($self.open) {
          $($self.filter + ' form').hide(); $(e.target).html('Open Filter'); $self.open = false;
        } else {
          $($self.filter + ' form').show(); $(e.target).html('Close Filter'); $self.open = true;
        }
    
      });
    
    $(this.filter).append(toggle);
  
  }

});

$(document).ready(function() {

  new UA5.Filter('.ua5_admin_filter');

});