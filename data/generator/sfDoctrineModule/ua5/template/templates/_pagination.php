<div class="ua5_admin_pagination">
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=1">
    [?php echo image_tag(sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/images/first.png', array('alt' => __('First page', array(), 'ua5_admin'), 'title' => __('First page', array(), 'ua5_admin'))) ?]
  </a>

  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]">
    [?php echo image_tag(sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/images/previous.png', array('alt' => __('Previous page', array(), 'ua5_admin'), 'title' => __('Previous page', array(), 'ua5_admin'))) ?]
  </a>

  [?php foreach ($pager->getLinks() as $page): ?]
    [?php if ($page == $pager->getPage()): ?]
      [?php echo $page ?]
    [?php else: ?]
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]">[?php echo $page ?]</a>
    [?php endif; ?]
  [?php endforeach; ?]

  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]">
    [?php echo image_tag(sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/images/next.png', array('alt' => __('Next page', array(), 'ua5_admin'), 'title' => __('Next page', array(), 'ua5_admin'))) ?]
  </a>

  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getLastPage() ?]">
    [?php echo image_tag(sfConfig::get('ua5_admin_module_web_dir', '/ua5AdminThemePlugin').'/images/last.png', array('alt' => __('Last page', array(), 'ua5_admin'), 'title' => __('Last page', array(), 'ua5_admin'))) ?]
  </a>
</div>
