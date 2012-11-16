<?php

class ua5ValidatorFormJQueryUIAutocomplete extends sfValidatorDoctrineChoice
{

  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('add_missing', true);
    $this->addOption('table_method', 'createQuery');
    parent::configure($options, $messages);
  }


  protected function doClean($value)
  {

    $model = $this->getOption('model');
    $column = $this->getOption('column');
    $table_method = $this->getOption('table_method');

    $obj = Doctrine_Core::getTable($model)
      ->$table_method()
      ->andWhere("$column = ?", $value)
      ->fetchOne();

    if ( !$obj ) {
      if ( !$this->getOption('add_missing') ) {
        throw new sfValidatorError($this, 'invalid', array('value' => $value));
      } else {
        $obj = new $model();
        $obj[$column] = $value;
        $obj->save();
      }
    }

    return $obj->getId();
  }
}
