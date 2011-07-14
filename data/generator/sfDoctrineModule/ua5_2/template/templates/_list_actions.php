<?php if ($actions = $this->configuration->getValue('list.actions')): ?>
<?php foreach ($actions as $name => $params): ?>
<?php if ('_new' !== $name): ?>
<li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
  <?php echo $name ?>
  <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, false), $params)."\n" ?>
</li>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>