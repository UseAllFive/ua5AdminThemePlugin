  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this-><?php echo $this->getModelClass() ?> = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
