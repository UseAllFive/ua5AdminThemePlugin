<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td class="ua5_admin_%s ua5_admin_list_td_%s">
  [?php echo %s ?]
</td>

EOF
, strtolower($field->getType()), $name, $this->renderField($field)), $field->getConfig()) ?>
<?php endforeach; ?>
