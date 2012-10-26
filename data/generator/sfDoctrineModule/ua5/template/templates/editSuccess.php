[?php use_helper('I18N', 'Date') ?]
[?php include_partial(
  '<?php echo $this->getModuleName(); ?>/assets',
  array(
    '<?php echo $this->getModuleName(); ?>' => isset($<?php echo $this->getModuleName(); ?>)?$<?php echo $this->getModuleName(); ?>:null,
  )
); ?]
[?php
slot("list_title");
echo '<h1>Edit <?php echo ucfirst($this->getSingularName()) ?></h1>';
end_slot("list_title");
?]

  <div id="ua5_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="ua5_admin_content">

    [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </div>

  <div id="ua5_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
