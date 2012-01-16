  public function executeAjaxDelete<?php echo $relation['alias']; ?>($request) {
    $json_response = array(
      'success'     => true,
      'id'          => $request['id'],
    );

    $obj = <?php echo get_class($relation['table']); ?>::getInstance()->find($request['id']);

    if($obj) {
      $obj->delete();
    } else {
      $json_response['success'] = false;
      $json_response['error_msg'] = sprintf(
        '%s with id (%s) not found',
        '<?php echo ucfirst($relation['alias']); ?>',
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
