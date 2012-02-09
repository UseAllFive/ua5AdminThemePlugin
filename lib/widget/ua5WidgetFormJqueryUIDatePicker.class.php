<?php

class ua5WidgetFormJQueryUIDatepicker extends sfWidgetFormDate {


  /**
   * Configures the current widget.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
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
    $formatted_value = date('m/d/Y', strtotime($value));
    $value_id = $this->generateId($name);
    JSUtil::appendOnReady(<<<EOF
      (function() {
        jQuery('#$value_id').datepicker();
      })();
EOF
    );
    return $this->renderTag('input', array('type' => 'text', 'name' => $name, 'value' => $formatted_value));
  }


  /**
   * Gets the Stylesheet paths associated with the widget.
   *
   * @return array An array of Stylesheet paths
   */
  public function getStylesheets() {
    return array(
      '/ua5AdminThemePlugin/ua5_2/css/jquery-ui/ua5_admin_theme/jquery-ui-ua5-admin-theme.css' => 'all'
    );
  }


  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavascripts() {
    return array('/ua5AdminThemePlugin/ua5_2/js/libs/jquery-ui-1.8.5.min.js');
  }

}