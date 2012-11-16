<?php

/*
 * To use this widget a few things need to happen:
 *   1)  the JS helper needs to be enabled:
 *         apps/admin/config/settings.yml:
 *           all:
 *             .settings:
 *               standard_helpers:       [Partial, Cache, JS]
 *   2)  jQuery and jQuery-ui need to be enabled on the page
 *
 */
class ua5WidgetFormJQueryUIDatetimePicker extends sfWidgetFormInput
{

  protected $default_jquery_datetimepicker_options = array(
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
  protected function configure($options = array(), $attributes = array())
  {

    sfConfig::set('app_ua5_cms_include_jquery_ui', true);

    $this->addOption('date_format', 'm/d/Y h:i a');
    $this->addOption('jquery_datetimepicker_options', array());

    parent::configure($options, $attributes);

    if ( $this->getOption('required') ) {
      $this->setDefault(date($this->getOption('date_format')));
    }

  }

  public function getJavaScripts()
  {
    return array(
      '/ua5AdminThemePlugin/ua5_2/js/libs/jquery-ui-timepicker-addon.js',
    );
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
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ( null === $value ) {
      $formatted_value = null;
    } else {
      $formatted_value = date($this->getOption('date_format'), strtotime($value));
    }
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
