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
  protected function configure($options = array(), $attributes = array()) {
    sfConfig::set('app_ua5_cms_include_jquery_ui', true);

    $this->addRequiredOption('model');
    $this->addOption('allow_other', false);
    $this->addOption('column', 'name');
    $this->addOption('table_method', 'createQuery');
    $this->addOption('url', '/ua5Autocomplete/lookup/model/%model%/table_method/%table_method%/column/%column%/value/%column%/term/');

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
    $model = $this->getOption('model');
    $table_method = $this->getOption('table_method');

    if ( $this->getOption('allow_other', false) ) {
      $visibleValue = $value;
    } else {
      if ( $model ) {
        $valueObj = Doctrine_Core::getTable($model)->find($value);
        $visibleValue = ($valueObj ? $valueObj[$column] : '');
      } else {
        $visibleValue = null;
      }
    }

    $value_id = $this->generateId($name);
    $url = str_replace(
      array(
        '%model%',
        '%table_method%',
        '%column%'
      ),
      array(
        $model,
        $table_method,
        $column,
      ),
      $this->getOption('url')
    );

    JSUtil::appendOnReady(<<<EOF

    (function () {
      var \$value = jQuery('#{$value_id}');

      \$value.autocomplete({
        source: function(request, response) {
          var entries = [];

          jQuery.get(
            (window.location.pathname.match(/^(\/[^\/]*.php)?/)[1] || '') +'{$url}'+ request.term,
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


}
