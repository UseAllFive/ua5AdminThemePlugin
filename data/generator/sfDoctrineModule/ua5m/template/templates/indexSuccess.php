[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="ua5_admin_container">

   <div id="bd-hd" class="yui-g">
   [?php include_partial('global/top_menu') ?]   
     <div class="yui-u first">
      <h1><?php echo sfInflector::humanize($this->getPluralName()) ?> List</h1>

      [?php include_partial('<?php echo $this->getModuleName() ?>/tabs') ?]       
      
     </div>
   </div>
   
   <div class="yui-u first">
   [?php include_partial('<?php echo $this->getModuleName() ?>/sub_tabs') ?]
   </div>         
    <div id="yui-main" class="yui-ge"> <!-- main content -->
                
      <div class="yui-u first">
      
         <div class="yui-b" id="bd-content">
    
           [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
         
           <div id="ua5_admin_header">
             [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
           </div>
   
                  
           <div id="ua5_admin_content">
                      <form action="#" method="post">
                      [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
                      </form>
                    </div>
         
           <div id="ua5_admin_footer">
             [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
           </div>
           
         </div>
    
      </div>
                   
      <div class="yui-u">  <!-- Right Side -->
       
        <div id="bd-secondary">
          
          [?php include_partial('<?php echo $this->getModuleName() ?>/right_column') ?]
      
        </div>               
      
      </div>                 <!-- End Right Side -->
  
    </div>          <!-- End Main Content Section -->

</div>



<table>
  <thead>
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
      <th><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?></th>
<?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    [?php foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): ?]
    <tr>
<?php foreach ($this->getColumns() as $column): ?>
<?php if ($column->isPrimaryKey()): ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
      <td><a href="[?php echo url_for('<?php echo $this->getUrlForAction(isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit') ?>', $<?php echo $this->getSingularName() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</a></td>
<?php else: ?>
      <td><a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/<?php echo isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit' ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</a></td>
<?php endif; ?>
<?php else: ?>
      <td>[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo sfInflector::camelize($column->getPhpName()) ?>() ?]</td>
<?php endif; ?>
<?php endforeach; ?>
    </tr>
    [?php endforeach; ?]
  </tbody>
</table>

<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
  <a href="[?php echo url_for('<?php echo $this->getUrlForAction('new') ?>') ?]">New</a>
<?php else: ?>
  <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/new') ?]">New</a>
<?php endif; ?>
