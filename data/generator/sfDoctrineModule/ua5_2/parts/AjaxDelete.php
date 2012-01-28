
  public function executeAjaxDelete<?php echo $relation['alias']; ?>($request) {
    return $this->ajaxDeleteGeneric(
      $request,
      '<?php echo get_class($relation['table']); ?>',
      '<?php echo ucfirst($relation['alias']); ?>'
    );
  }
