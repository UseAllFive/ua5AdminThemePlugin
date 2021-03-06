[?php use_stylesheet('http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css', 'first') ?]
[?php use_stylesheet('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/css/admin.css' ?>', 'first') ?]


[?php use_javascript('//ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.js', 'first') ?]
[?php use_javascript('//ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/js/classy.js' ?>', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/js/ua5.js' ?>', 'first') ?]


<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?>
[?php use_stylesheet('<?php echo $this->params['css'] ?>') ?]
<?php endif; ?>

[?php
slot("list_title");
include_partial("list_title");
end_slot("list_title");

slot("tabs");
include_partial("global/tabs", array('active' => ''));
end_slot("tabs");

slot("sub_tabs");
include_partial("sub_tabs");
end_slot("sub_tabs");

slot("right_column");
  $vars = array();
  if ( isset($filters) ) { $vars['filters'] = $filters; }
  if ( isset($<?php echo $this->getModuleName() ?>) ) {
    $vars['<?php echo $this->getModuleName(); ?>'] = $<?php echo $this->getModuleName(); ?>;
  }
  include_partial("right_column", $vars);
end_slot("right_column");

?]
