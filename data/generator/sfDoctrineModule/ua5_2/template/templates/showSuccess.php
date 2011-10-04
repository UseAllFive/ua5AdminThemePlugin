[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container">
  <h1>Show <?php echo sfInflector::humanize($this->getModuleName()); ?></h1>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

<?php /*
  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
 */ ?>

  <div id="sf_admin_content">
    <div class="sf_admin_form r_5">
      <dl>
      [?php foreach ($columns as $column): ?]
        <dt>[?php echo $column; ?]</dt>
        <dd>[?php echo $<?php echo $this->getSingularName() ?>[$column]; ?]</dd>

      [?php endforeach; ?]
      </dl>
    </div>
  </div>

<?php /*
  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
 */ ?>
</div>
