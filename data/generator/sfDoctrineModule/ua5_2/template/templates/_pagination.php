<div class="sf_admin_pagination">
  [?php $prev_page = (int)$pager->getPreviousPage(); ?]
  [?php $next_page = (int)$pager->getNextPage(); ?]


  <!-- first page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=1">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?]
  </a>
  -->

  [?php if ( $pager->getPage() != $prev_page ) : ?]
  <div class="prev_page clearfix">
    <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $prev_page; ?]" class="">
      Previous Page
    </a>
  </div>
  [?php endif; ?]


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
  
  [?php if ( $pager->getPage() != $next_page ) : ?]
  <div class="next_page clearfix">
    <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $next_page; ?]" class="">
      Next Page
    </a>
  </div>
  [?php endif; ?]

  <!-- last page -->
  <!--
  <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getLastPage() ?]">
    [?php echo image_tag('/ua5AdminThemePlugin/ua5_2/img/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))) ?]
  </a>
  -->

</div>
