<ul class="nav">


<?php /*


<?php
  $modules = array(
    'category',
  );
?>
<?php foreach ( $modules as $module ) : ?>
<?php
        $class = Doctrine_Inflector::urlize($module);
        if ( $sf_request->getParameter('module')==$module ) {
          $class.=' rl c_p3 rl_5 active';
        }
?>
  <li class="l1 <?php echo $class; ?>">
    <?php echo link_to('<span class="icon"></span>'.ucfirst(sfInflector::humanize($module)), $module.'/index'); ?> 
  </li>
<?php endforeach; ?>


*/ ?>


  <li class="l1 last">
  </li>
</ul>
