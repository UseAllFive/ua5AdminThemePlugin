<?php

class ua5WidgetFormJQueryUIDatetimePicker extends sfWidgetFormInput {


  protected
    $default_jquery_datetimepicker_options = array(
      'ampm' => true,
    );


  /**
   * Configures the current widget.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array()) {

    sfConfig::set('app_ua5_cms_include_jquery_ui', true);

    $this->addOption('date_format', 'm/d/Y h:i a');
    $this->addOption('jquery_datetimepicker_options', array());

    parent::configure($options, $attributes);

    $this->setDefault(date($this->getOption('date_format')));

  }


  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $formatted_value = date($this->getOption('date_format'), strtotime($value));
    $value_id = $this->generateId($name);
    $js_options = json_encode(array_merge(
      $this->default_jquery_datetimepicker_options,
      $this->getOption('jquery_datetimepicker_options', array())
    ));
    JSUtil::appendOnReady(<<<EOF
      (function() {
        jQuery('#$value_id').datetimepicker($js_options);
      })();
EOF
    );
    return $this->renderTag('input', array('type' => 'text', 'name' => $name, 'value' => $formatted_value));
  }

}
