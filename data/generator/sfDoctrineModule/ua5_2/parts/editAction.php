  public function executeEdit(sfWebRequest $request)
  {
    $this-><?php echo $this->getModelClass() ?> = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this-><?php echo $this->getModelClass() ?>);
  }
