  public function executeShow(sfWebRequest $request)
  {
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    $this->columns = array_keys($this-><?php echo $this->getSingularName() ?>->getTable()->getColumns());
  }
