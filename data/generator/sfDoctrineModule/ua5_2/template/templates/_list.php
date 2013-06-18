<?php
$column_count =
  count($this->configuration->getValue('list.display')) +
  ($this->configuration->getValue('list.object_actions') ? 1 : 0) +
  ($this->configuration->getValue('list.batch_actions') ? 1 : 0);
$isSortable = $this->table->hasTemplate('Sortable');
?>
<?php if ($isSortable): ?>
    [?php sfConfig::set('app_ua5_cms_include_jquery_ui', true); ?]
    [?php js_append_onready(<<<EOT
        ua5_cms.sortable.init(
            '<?php echo $this->getModelClass(); ?>',
            '.sf_admin_list.<?php echo $this->getModelClass(); ?>>table>tbody'
        );
EOT
);

    ?]
<?php endif; ?>

<div class="sf_admin_list <?php echo $this->getModelClass(); ?>">
  [?php if (!$pager->getNbResults()): ?]
    <p>[?php echo __('No result', array(), 'sf_admin') ?]</p>
  [?php else: ?]
    <table class="r_5" cellspacing="0">
      <thead>
        <tr>
<?php if ($isSortable): ?>
          <th id="sf_admin_list_th_sortable" class="rtl_5"></th>
<?php endif; ?>
          [?php include_partial('<?php echo $this->getModuleName() ?>/list_th_<?php echo $this->configuration->getValue('list.layout') ?>', array('sort' => $sort)) ?]
<?php if ($this->configuration->getValue('list.object_actions')): ?>
          <th id="sf_admin_list_th_actions">[?php echo __('Actions', array(), 'sf_admin') ?]</th>
<?php endif; ?>
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
          <th id="sf_admin_list_batch_actions" class="rtr_5 batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
<?php endif; ?>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="<?php echo $column_count + ($isSortable ? 1 : 0) ?>" class="rb_5">
            <div class="sf_admin_batch_actions">
              [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
            </div>
      
            [?php if ($pager->haveToPaginate()): ?]
              [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
            [?php endif; ?]
          </th>
        </tr>
      </tfoot>
      <tbody>
        [?php foreach ($pager->getResults() as $i => $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?]
          <tr class="sf_admin_row [?php echo $odd ?]" data-id="[?php echo $<?php echo $this->getSingularName(); ?>['id']; ?]">
<?php if ($isSortable): ?>
            <td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
<?php endif; ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_<?php echo $this->configuration->getValue('list.layout') ?>', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]
<?php if($this->configuration->getValue('list.object_actions')): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
<?php endif; ?>
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_batch_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
<?php endif; ?>
          </tr>
        [?php endforeach; ?]
      </tbody>
    </table>
  [?php endif; ?]
</div>
<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>
