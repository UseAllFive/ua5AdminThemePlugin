  public function executeShow(sfWebRequest $request)
  {
    $this-><?php echo $this->getModelClass() ?> = $this->getRoute()->getObject();
    $this->columns = array_keys($this-><?php echo $this->getModelClass() ?>->getTable()->getColumns());
  }
