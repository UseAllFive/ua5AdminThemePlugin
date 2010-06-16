<?php
class cwTabsFilter extends sfFilter {
	public function execute($filterChain) {
		$param = $this->getParameter("param_holder");
		if ($this->hasParameter ($param)) {
	    $this->getContext ()->set ( $param, $this->getParameter ( $param ));		
		}
		$filterChain->execute ();
	}
}
