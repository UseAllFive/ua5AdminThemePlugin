  public function executeNew(sfWebRequest $request)
  {
    $<?php echo $this->getSingularName() ?> = new <?php echo $this->getModelClass(); ?>();
    $<?php echo $this->getSingularName() ?>->fromArray($request->getParameter('<?php echo $this->getModelClass(); ?>', array()));
    $this->form = $this->configuration->getForm($<?php echo $this->getSingularName() ?>);
    $this-><?php echo $this->getSingularName() ?> = $this->form->getObject();
  }
