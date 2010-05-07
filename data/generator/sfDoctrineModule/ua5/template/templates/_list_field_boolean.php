[?php if ($value): ?]
  [?php echo image_tag(sfConfig::get('ua5_admin_module_web_dir').'/images/tick.png', array('alt' => __('Checked', array(), 'ua5_admin'), 'title' => __('Checked', array(), 'ua5_admin'))) ?]
[?php else: ?]
  &nbsp;
[?php endif; ?]
