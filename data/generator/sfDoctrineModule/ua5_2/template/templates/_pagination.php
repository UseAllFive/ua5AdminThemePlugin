<div class="sf_admin_pagination">
  <!-- first page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=1">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?]
  </a>
  -->

  <!-- previous page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))) ?]
  </a>
  -->
  
  <!-- pages -->
  <ul>
    [?php foreach ($pager->getLinks() as $page): ?]
      [?php if ($page == $pager->getPage()): ?]
        <li class="active">[?php echo $page ?]</li>
      [?php else: ?]
        <li><a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]">[?php echo $page ?]</a></li>
      [?php endif; ?]
    [?php endforeach; ?]
  </ul>
  
  <div>
    <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]" class="next_page">
      Next Page
    </a>
  </div>
  
  <!-- next page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))) ?]
  </a>
  -->

  <!-- last page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getLastPage() ?]">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))) ?]
  </a>
  -->
    

</div>
