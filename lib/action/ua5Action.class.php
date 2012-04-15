<?php

abstract class ua5Action extends sfAction {


  /**
   * Appends the given data as JSON to the response content and bypasses the built-in view system.
   *
   * This method must be called as with a return:
   *
   * <code>return $this->renderJson($myData)</code>
   *
   * @param string $json JSON to append to the response
   *
   * @return sfView::NONE
   */
  public function renderJson($json) {
    self::setJsonResponseHeaders($this->getResponse());

    return $this->renderText(json_encode($json));
  }


  public function setResponseCacheDuration($timeout) {
    $response = $this->getResponse();

    if ( false === $timeout || 0 === $timeout ) {
      // prevent response caching on client side
      $response->addCacheControlHttpHeader('no-cache, must-revalidate');
      $response->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
    } else {
      $response->addCacheControlHttpHeader('max-age='.$timeout);
      $response->setHttpHeader('Pragma', 'public');
      $response->setHttpHeader('Expires', gmdate('D, j M Y H:i:s e', time()+$timeout));
    }
    return $response;
  }


  static public function setJsonResponseHeaders(sfResponse $response) {
    $response->setContentType('application/json');

    return $response;
  }


  /**
   * Forwards current action to the default 403 error action unless the specified condition is true.
   *
   * @param bool    $condition  A condition that evaluates to true or false
   * @param string  $message    Message of the generated exception
   *
   */
  public function forward403Unless($condition, $message = null) {
    if (!$condition) {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }
  }


}
