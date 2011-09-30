  public function getShowTableMethod()
  {
    return '<?php echo isset($this->config['show']['table_method']) ? $this->config['show']['table_method'] : null ?>';
    <?php unset($this->config['show']['table_method']) ?>
  }
