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


  static public function setJsonResponseHeaders(sfResponse $response) {
    $response->setContentType('application/json');

    // prevent response caching on client side
    $response->addCacheControlHttpHeader('no-cache, must-revalidate');
    $response->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');

    return $response;
  }


}
