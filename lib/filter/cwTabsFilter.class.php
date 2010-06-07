<?php
class cwTabsFilter extends sfFilter {
	public function execute($filterChain) {
		if ($this->hasParameter ( "tabs" )) {
	    $this->getContext ()->set ( "tabs", $this->getParameter ( "tabs" ));		
		}
		$filterChain->execute ();
	}
}
