  public function executePromote(sfWebRequest $request)
  {
    $this->getRoute()->getObject()->promote();
    $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
  }


  public function executeDemote() {
    $this->getRoute()->getObject()->demote();
    $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
  }
