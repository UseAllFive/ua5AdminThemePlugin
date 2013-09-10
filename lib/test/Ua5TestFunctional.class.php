<?php

class Ua5TestFunctional extends sfTestFunctional
{

  public function __construct(sfBrowserBase $browser, lime_test $lime = null, $testers = array())
  {
    $testers = array_merge(
      array(
        'response' => 'ua5TesterResponse',
      ), 
      $testers
    );

    parent::__construct($browser, $lime, $testers);
  }
}
