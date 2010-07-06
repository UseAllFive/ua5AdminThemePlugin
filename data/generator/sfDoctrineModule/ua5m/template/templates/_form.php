[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="ua5_admin_form">
<?php $form = $this->getFormObject() ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>') ?]
<?php else: ?>
<form action="[?php echo url_for('<?php echo $this->getModuleName() ?>/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?> : '')) ?]" method="post" [?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?]>
[?php if (!$form->getObject()->isNew()): ?]
<input type="hidden" name="sf_method" value="put" />
[?php endif; ?]
<?php endif;?>

<fieldset id="sf_fieldset_<?php echo $this->getModuleName() ?>">
<h2><?php echo $this->getModuleName() ?></h2>
[?php echo $form->renderGlobalErrors() ?]

<ul class="ua5_admin_fieldset_fields">
<?php foreach ($form as $name => $field): if ($field->isHidden()) continue ?>
<?php /*      <tr>
        <th></th>
        <td>
          [?php echo $form['<?php echo $name ?>']->renderError() ?]
          [?php echo $form['<?php echo $name ?>'] ?]
        </td>
      </tr>
  <li class="[?php echo $class ?][?php $form[$name]->hasError() and print ' errors' ?]">
    [?php echo $form[$name]->renderError() ?]
    <div>
      [?php echo $form[$name]->renderLabel($label) ?]

      <div class="content">[?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]</div>

      [?php if ($help): ?]
        <div class="help">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</div>
      [?php elseif ($help = $form[$name]->renderHelp()): ?]
        <div class="help">[?php echo $help ?]</div>
      [?php endif; ?]
    </div>
  </li>*/?>
  
<li class="ua5_admin_form_row ua5_admin_text ua5_admin_form_field_<?php echo $name ?>">
  [?php echo $form['<?php echo $name ?>']->renderError() ?]
  <div>
    [?php echo $form['<?php echo $name ?>']->renderLabel() ?]
    <div class="content">[?php echo $form['<?php echo $name ?>']->render() ?]</div>       
  </div>
</li>
<?php endforeach; ?>

</ul>
<?php if (!isset($this->params['non_verbose_templates']) || !$this->params['non_verbose_templates']): ?>
          [?php echo $form->renderHiddenFields(false) ?]
<?php endif; ?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
          &nbsp;<a href="[?php echo url_for('<?php echo $this->getUrlForAction('list') ?>') ?]">Back to list</a>
<?php else: ?>
          &nbsp;<a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/index') ?]">Back to list</a>
<?php endif; ?>
          [?php if (!$form->getObject()->isNew()): ?]
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
            &nbsp;[?php echo link_to('Delete', '<?php echo $this->getUrlForAction('delete') ?>', $form->getObject(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?]
<?php else: ?>
            &nbsp;[?php echo link_to('Delete', '<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams('$form->getObject()', true) ?>, array('method' => 'delete', 'confirm' => 'Are you sure?')) ?]
<?php endif; ?>
          [?php endif; ?]
          <input type="submit" value="Save" />
          

</form>

</div>