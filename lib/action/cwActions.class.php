<?php

/*
 * FIXME: Where is this used?  Nothing since at lease AIALosAngeles AFAIK ^m14t
 *
 */
class cwActions extends sfActions {


  public function preExecute() {
    sfConfig::set('sf_app_template_dir', sfConfig::get("sf_plugins_dir").'/ua5AdminThemePlugin/templates');
    parent::preExecute();
  }


}
