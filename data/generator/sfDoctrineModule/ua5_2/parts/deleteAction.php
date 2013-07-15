  protected function getDeleteRedirect($objData)
  {
    return('@<?php echo $this->getUrlForAction('list') ?>');
  }


  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $obj = $this->getRoute()->getObject();
    $objData = $obj->toArray();
    if ($obj->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect($this->getDeleteRedirect($objData));
  }
