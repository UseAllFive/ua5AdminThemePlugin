<?php

/**
 * pressGuardAuth actions.
 *
 * @package    press_ms
 * @subpackage pressGuardAuth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
require_once(dirname(__FILE__).'/../../../..//sfDoctrineGuardPlugin/modules/sfGuardAuth/actions/actions.class.php');

class ua5GuardAuthActions extends sfGuardAuthActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSignin($request)
  {
  	parent::executeSignin($request);
  	$this->setLayout("login_layout");
    //$this->forward('default', 'module');
  }
}
