<?php
class cwActiveTabFilter extends sfFilter
{

  public function execute($filterChain)
  {
    sfConfig::set('sf_app_template_dir', sfConfig::get("sf_plugins_dir").'/ua5AdminThemePlugin/templates');
    $filterChain->execute ();
  }
}
