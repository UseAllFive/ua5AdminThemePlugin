<?php


class ua5WidgetFormJQueryUIAutocomplete extends sfWidgetFormDoctrineChoice {
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   *  * model:          The model to perform the lookup on (required)
   *  * column:         The field to return (defaults to 'name')
   *  * url:            The URL to call to get the choices to use
   *  * value_callback: A callback that converts the value before it is displayed
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('model');
    $this->addOption('column', 'name');
    $this->addOption('url', '/ua5Autocomplete/lookup/model/%model%/label/%column%/value/%column%/term/');

    parent::configure($options, $attributes);
  }


  /**
   * Returns the choices associated to the model.
   *
   * @return array An array of choices
   */
  public function getChoices() {
    return array();
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

    $column = $this->getOption('column');
    $valueObj = Doctrine_Core::getTable($this->getOption('model'))->find($value);
    $visibleValue = ($valueObj ? $valueObj[$column] : '');

    $value_id = $this->generateId($name);
    $url = str_replace(
      array('%model%', '%column%'),
      array($this->getOption('model'), $this->getOption('column')),
      $this->getOption('url')
    );

    JSUtil::appendOnReady(<<<EOF

    (function () {
      var \$value = jQuery('#{$value_id}');

      \$value.autocomplete({
        source: function(request, response) {
          var entries = [];

          jQuery.get(
            ua5_cms.script_name +'{$url}'+ request.term,
            function(data) {
              response(data.entries);
            },
            'json'
          );
        },
        select: function(event, ui) {
          \$value.val(ui.item.label);
          return false;
        }
      });
    })();
EOF
    );
    return $this->renderTag('input', array('type' => 'text', 'name' => $name, 'value' => $visibleValue));

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
