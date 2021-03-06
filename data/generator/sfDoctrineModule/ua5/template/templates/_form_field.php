[?php if ($field->isPartial()): ?]
  [?php include_partial(
          '<?php echo $this->getModuleName() ?>/'.$name, 
          array(
            'form' => $form,
            'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes,
            '<?php echo $this->getModuleName() ?>' => $<?php echo $this->getModuleName() ?>
          )
  ) ?]
[?php elseif ($field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php else: ?]
  <li class="[?php echo $class ?][?php $form[$name]->hasError() and print ' errors' ?]">
    [?php echo $form[$name]->renderError() ?]
    <div>
[?php if($form[$name]->getWidget() instanceof sfWidgetFormInputCheckbox):?]
      <div class="content checkbox">[?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]</div>
      
	  [?php echo $form[$name]->renderLabel($label) ?]      
[?php else:?]
    
      [?php echo $form[$name]->renderLabel($label) ?]

      <div class="content">[?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]</div>
[?php endif;?]

      [?php if ($help): ?]
        <div class="help">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</div>
      [?php elseif ($help = $form[$name]->renderHelp()): ?]
        <div class="help">[?php echo $help ?]</div>
      [?php endif; ?]
    </div>
  </li>
[?php endif; ?]

