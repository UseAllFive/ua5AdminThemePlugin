<?php

/*
 * This is a direct copy of sfActions, but extends ua5Action instead of sfAction
 *
 */
abstract class ua5Actions extends ua5Action
{
  /**
   * Dispatches to the action defined by the 'action' parameter of the sfRequest object.
   *
   * This method try to execute the executeXXX() method of the current object where XXX is the
   * defined action name.
   *
   * @param sfRequest $request The current sfRequest object
   *
   * @return string    A string containing the view name associated with this action
   *
   * @throws sfInitializationException
   *
   * @see sfAction
   */
  public function execute($request)
  {
    // dispatch action
    $actionToRun = 'execute'.ucfirst($this->getActionName());

    if ($actionToRun === 'execute') {
      // no action given
      throw new sfInitializationException(
        sprintf(
          'sfAction initialization failed for module "%s". There was no action given.',
          $this->getModuleName()
        )
      );
    }

    if (!is_callable(array($this, $actionToRun))) {
      // action not found
      throw new sfInitializationException(
        sprintf(
          'sfAction initialization failed for module "%s", action "%s". You must create a "%s" method.',
          $this->getModuleName(),
          $this->getActionName(),
          $actionToRun
        )
      );
    }

    if (sfConfig::get('sf_logging_enabled')) {
      $this->dispatcher->notify(
        new sfEvent(
          $this,
          'application.log',
          array(sprintf(
            'Call "%s->%s()"',
            get_class($this),
            $actionToRun
          ))
        )
      );
    }

    // run action
    return $this->$actionToRun($request);
  }
}
