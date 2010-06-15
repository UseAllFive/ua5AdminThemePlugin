<?php 

class cwActions extends sfActions
{
	function preExecute()
	{
    sfConfig::set('sf_app_template_dir', sfConfig::get("sf_plugins_dir").'/ua5AdminThemePlugin/templates');
    parent::preExecute();
	}
}