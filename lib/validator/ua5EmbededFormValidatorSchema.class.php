<?php

class ua5EmbededFormValidatorSchema extends sfValidatorSchema {

  protected
    $required_fields = array(),
    $required_fields_count = array();


  public function __construct($options = array(), $messages = array()) {
    foreach( $options['fields'] as $subform_name => $subform_validator_schema ) {
      $this->required_fields[$subform_name] = array();
      foreach ( $subform_validator_schema->getFields() as $name => $field ) {
        if ( true === $field->getOption('required', false) ) {
          $this->required_fields[$subform_name][$name] = $field;
        }
      }
      $this->required_fields_count[$subform_name] = count($this->required_fields[$subform_name]);
    }

    //-- Don't pass the form along
    unset($options['fields']);

    return parent::__construct($options, $messages);
  }


  protected function configure($options = array(), $messages = array()) {
/*
    foreach( $this->required_fields as $subform_name => $fields ) {
      foreach( $fieldsas $name => $field ) {
        $this->addMessage('caption', 'The '. sfInflector::humanize($name) .' is required.');
      }
    }
*/
  }

  protected function doClean($subforms) {
    $errorSchema = new sfValidatorErrorSchema($this);

    foreach ( $subforms as $subform_name => $subform_values ) {

      $errorSchemaLocal = new sfValidatorErrorSchema($this);
      $at_least_one_value_set = false;

      //-- unset the required_fields that have values
      if ( array_key_exists($subform_name, $this->required_fields) ) {
        if ( $subform_values ) {
          foreach ( $subform_values as $name => $value ) {
            if ( array_key_exists($name, $this->required_fields[$subform_name]) ) {
              //-- There is a value and the field is required
              unset($this->required_fields[$subform_name][$name]);
            }
            if ( $value ) {
              $at_least_one_value_set = true;
            }
          }
        }
      }


      if ( array_key_exists($subform_name, $this->required_fields) ) {
        foreach( $this->required_fields[$subform_name] as $name => $field ) {
          $errorSchemaLocal->addError(new sfValidatorError($this, 'required'), $name);
        }
      }


      // throws the error for the main form
      if ( count($errorSchemaLocal) ) {
        $errorSchema->addError($errorSchemaLocal[$subform_name], (string) $subform_name);
      /* Shouldn't this be like this? 
        $errorSchema->addError(new sfValidatorError($this, (string) $subform_name));
       */
      }


      //-- FIXME:  -- we never throw $errorSchema?

      if (
        !$at_least_one_value_set &&
        count($this->required_fields[$subform_name]) === $this->required_fields_count[$subform_name]
      ) {
        unset($subforms[$subform_name]);
      }

    }

    return $subforms;
  }
}
