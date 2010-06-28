<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfDoctrineGuardPlugin configuration.
 * 
 * @package    sfDoctrineGuardPlugin
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfDoctrineGuardPluginConfiguration.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class ua5AdminThemePluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    if (sfConfig::get('app_sf_guard_plugin_routes_register', true) && in_array('ua5GuardAuth', sfConfig::get('sf_enabled_modules', array())))
    {
      $this->dispatcher->connect('routing.load_configuration', array('ua5GuardRouting', 'listenToRoutingLoadConfigurationEvent'));
    }
  }
}
