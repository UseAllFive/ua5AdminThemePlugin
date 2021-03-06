<?php if ($listActions = $this->configuration->getValue('list.batch_actions')): ?>
<li class="ua5_admin_batch_actions_choice">
  <select name="batch_action">
    <option value="">[?php echo __('Choose an action', array(), 'ua5_admin') ?]</option>
<?php foreach ((array) $listActions as $action => $params): ?>
    <?php echo $this->addCredentialCondition('<option value="'.$action.'">[?php echo __(\''.$params['label'].'\', array(), \'ua5_admin\') ?]</option>', $params) ?>

<?php endforeach; ?>
  </select>
  [?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?]
    <input type="hidden" name="[?php echo $form->getCSRFFieldName() ?]" value="[?php echo $form->getCSRFToken() ?]" />
  [?php endif; ?]
  <input type="submit" value="[?php echo __('go', array(), 'ua5_admin') ?]" />
</li>
<?php endif; ?>
