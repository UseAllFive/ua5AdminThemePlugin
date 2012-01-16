<?php

class ua5ValidatorFormJQueryUIAutocomplete extends sfValidatorDoctrineChoice {

  protected function configure($options = array(), $messages = array()) {
    $this->addOption('add_missing', true);
    parent::configure($options, $messages);
  }


  protected function doClean($value) {

    $model = $this->getOption('model');
    $column = $this->getOption('column');
    $method = 'findOneBy'.ucfirst($column);

    $obj = Doctrine_Core::getTable($model)->$method($value);
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
