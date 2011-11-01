<?php

class JSUtil {
  
  protected static $inline = array();
  protected static $onReady = array();
  
  /**
   * Append arbitrary JS to the end of the document
   * 
   * @param type $js 
   */
  public static function appendInline($js) {
    self::$inline[] = $js;
  }
  
  /**
   * Calls will be triggered inside of $.ready at the end of the document. Depends
   * on jQuery.
   * 
   * @param type $js 
   */
  public static function appendOnReady($js) {
    self::$onReady[] = $js;
  }
  
  /**
   * If you want placeholders (as are used in Apostrphe's aHelper), you can
   * decorate your js with this method before giving it to the append functions.
   * 
   * $js is arbitrary javascript, and can contain placeholders (question marks) that
   * will be replaced with $args, in order, where each arg is json_encode()'d.
   * 
   * @throws sfException when number of args doesn't match number of placeholders
   */
  public static function interpolateJSArgs($js, array $args) {
    $clauses = preg_split('/(\?)/', $js, null, PREG_SPLIT_DELIM_CAPTURE);
    $code = '';
    $n = 0;
    $q = 0;
    
    foreach($clauses as $clause) {
      if($clause === '?') {
        $code .= json_encode($args[$n++]);
      } else {
        $code .= $clause;
      }
    }
    
    if($n !== count($args)) {
      throw new sfException('Number of arguments does not match number of ? placeholders in js call');
    }
    
    return $code;
  }
  
  public static function dump() {
    $out = '';
    
    // accumulate inline JS
    if(count(self::$inline)) {
      foreach(self::$inline as $js) {
        $out .= $js . "\n\n";
      }
    }
    
    // accumulate onready js
    if(count(self::$onReady)) {
      $out .= 'jQuery(function() {' . "\n";
      foreach(self::$onReady as $js) {
        $out .= $js . "\n\n";
      }
      $out .= "});\n";
    }
    
    if($out) {
      $out = '<script type="text/javascript">' . "\n" . $out . "</script>\n";
    }
    
    return $out;
  }
}