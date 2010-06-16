[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
[?php 
$expand_filter = false;
if(false != $filters = $sf_user->getAttribute('<?php echo $this->getModuleName() ?>.filters',false, 'admin_module'))
{
  if ($filters->count()!=0)
  {
    $expand_filter = true;
  }
}
?]

<div class="ua5_admin_filter">

  <h2>Filter Results</h2>

  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post"
  class='[?php if ($expand_filter==true) { echo 'expanded_filter';}?]'>

    <ul class="ua5_admin_filter_fields">
    
      [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
      [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
        [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
          'name'       => $name,
          'attributes' => $field->getConfig('attributes', array()),
          'label'      => $field->getConfig('label'),
          'help'       => $field->getConfig('help'),
          'form'       => $form,
          'field'      => $field,
          'class'      => 'ua5_admin_form_row ua5_admin_'.strtolower($field->getType()).' ua5_admin_filter_field_'.$name,
        )) ?]
      [?php endforeach; ?]
      
    </ul>
    
    <div class="ua5_admin_filter_submit">
      [?php echo $form->renderHiddenFields() ?]
      <input type="submit" value="[?php echo __('Filter', array(), 'ua5_admin') ?]" class="round" />
      [?php echo link_to(__('Reset', array(), 'ua5_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]
    </div>
      
  </form>
</div>

[?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
  [?php endif; ?]
