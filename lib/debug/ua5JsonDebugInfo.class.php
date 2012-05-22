<?php

class ua5JsonDebugInfo {


  protected
    $classes = array(),
    $default_classes = array(
      'ua5JsonDebugInfoMemory',
      'ua5JsonDebugInfoDoctrine',
    );

  public function __construct($classes = null) {
    if ( null === $classes ) {
      $this->classes = $this->default_classes;
    }
  }


  public function jsonSerialize() {
    $json = array();
    foreach ( $this->classes as $class ) {
      $obj = new $class();
      $json = array_merge($json, $obj->jsonSerialize());
    }
    return $json;
  }


}
