<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?> 
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?] 
<?php elseif(!isset($this->params['css'])): ?> 
[?php use_stylesheet('<?php echo sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/css/style.css' ?>', 'first') ?]  
<?php endif; ?>