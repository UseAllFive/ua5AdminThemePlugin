<?php 
class cwActiveTabFilter extends sfFilter
{
  public function execute($filterChain) {
    if ($this->hasParameter ( "active" )) {
      $this->getContext ()->set( "active_tab", $this->getParameter ( "active" ) );
    }
    $filterChain->execute ();
  }
}