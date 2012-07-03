  public function executeShow(sfWebRequest $request)
  {
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    //-- In an attempt to allow configuration of the Show Action's 
    //   fields in the generator.yml file, we are:
    //     replacing this next line:
    //$this->columns = array_keys($this-><?php echo $this->getSingularName() ?>->getTable()->getColumns());
    //     with:
    $this->columns = $this->configuration->getShowDisplay();
  }
