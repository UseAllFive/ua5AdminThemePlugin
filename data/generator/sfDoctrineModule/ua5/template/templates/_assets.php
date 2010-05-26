[?php use_stylesheet('http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css', 'first') ?]  
[?php use_stylesheet('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/css/admin.css' ?>') ?]


[?php use_javascript('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/js/classy.js' ?>', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/js/ua5.js' ?>', 'first') ?]


<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?> 
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?] 
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
include_partial("right_column");
end_slot("right_column");

?]