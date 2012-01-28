  protected function ajaxDeleteGeneric($request, $table_class, $class_name) {
    $json_response = array(
      'success'     => true,
      'id'          => $request['id'],
    );

    $obj = $table_class::getInstance()->find($request['id']);

    if($obj) {
      try {
        $obj->delete();
      } catch ( Doctrine_Connection_Mysql_Exception $e ) {
        $json_response['success'] = false;
        $json_response['error_msg'] = sprintf(
          'Could not delete %s with id (%s): %s',
          $class_name,
          $request['id'],
          $e->getMessage()
        );
      }
    } else {
      $json_response['success'] = false;
      $json_response['error_msg'] = sprintf(
        '%s with id (%s) not found',
        $class_name,
        $request['id']
      );
    }

    // set json response headers
    $response = $this->getResponse();
    $response->setContentType('application/json');

    // prevent response caching on client side
    $response->addCacheControlHttpHeader('no-cache, must-revalidate');
    $response->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');

    return $this->renderText(json_encode($json_response));
  }
