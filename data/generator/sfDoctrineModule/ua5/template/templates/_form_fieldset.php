<fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
  [?php if ('NONE' != $fieldset): ?]
    <h2>[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</h2>
  [?php endif; ?]
  
  <ul class="ua5_admin_fieldset_fields">

    [?php foreach ($fields as $name => $field): ?]
      [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
      [?php include_partial('<?php echo $this->getModuleName() ?>/form_field', array(
        'name'       => $name,
        'attributes' => $field->getConfig('attributes', array()),
        'label'      => $field->getConfig('label'),
        'help'       => $field->getConfig('help'),
        'form'       => $form,
        'field'      => $field,
        'class'      => 'ua5_admin_form_row ua5_admin_'.strtolower($field->getType()).' ua5_admin_form_field_'.$name,
      )) ?]
    [?php endforeach; ?]
  
  </ul>
  
</fieldset>
