[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container">
  <h1>Show <?php echo sfInflector::humanize($this->getModuleName()); ?></h1>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes', array('form' => $form)) ?]

<?php /*
  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
 */ ?>

  <div id="sf_admin_content">
    <div class="sf_admin_form r_5">
      <dl>
      [?php $table = $<?php echo $this->getSingularName() ?>->getTable(); ?]
      [?php foreach ($columns as $column): ?]
        <dt>[?php echo ucwords(sfInflector::humanize(sfInflector::tableize($column))); ?]</dt>
        <dd>
        [?php if (
          $table->hasRelation($column) &&
          Doctrine_Relation::MANY === $table->getRelation($column)->getType()
        ): ?]
          <ul>
          [?php foreach ( $<?php echo $this->getSingularName() ?>[$column] as $relation_row ): ?]
            <li>[?php echo $relation_row; ?]</li>
          [?php endforeach; ?]
          </ul>
        [?php else: ?]
          [?php echo $<?php echo $this->getSingularName() ?>[$column]; ?]
        [?php endif; ?]
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
