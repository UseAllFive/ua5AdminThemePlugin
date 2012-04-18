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
      //-- References:
      //   https://developers.google.com/speed/docs/best-practices/caching
      //   
      /* */
      //-- What it seems like we should send
      $response->addCacheControlHttpHeader(sprintf('max-age=%s, public, must-revalidate', $timeout));
      $response->setHttpHeader('Expires', gmdate('D, j M Y H:i:s \G\M\T', time()+$timeout));
      $response->setHttpHeader('Last-modified', gmdate('D, j M Y H:i:s \G\M\T', time()));
      header_remove('Pragma');
      /* */

      /*
      //-- Attempts to make it work
      $response->addCacheControlHttpHeader(sprintf('max-age=%s, public', $timeout));
      $response->setHttpHeader('Expires', gmdate('D, j M Y H:i:s \G\M\T', time()+$timeout));
      $response->setHttpHeader('Last-modified', 'Mon, 26 Jul 1997 05:00:00 GMT');
      //$response->setHttpHeader('Pragma', 'public');
      header_remove('Cookie');
      header_remove('Set-Cookie');
      /* */
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