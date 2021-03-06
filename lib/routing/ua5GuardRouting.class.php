<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardRouting.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class ua5GuardRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   * @static
   */
  public static function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    // preprend our routes
    $r->prependRoute('sf_guard_signin', new sfRoute(
      '/login',
      array('module' => 'ua5GuardAuth', 'action' => 'signin')
    ));
    $r->prependRoute('sf_guard_signout', new sfRoute(
      '/logout',
      array('module' => 'ua5GuardAuth', 'action' => 'signout')
    ));
    $r->prependRoute('sf_guard_password', new sfRoute(
      '/request_password',
      array('module' => 'ua5GuardAuth', 'action' => 'password')
    ));
  }

  /**
   * Adds an sfDoctrineRouteCollection collection to manage users.
   *
   * @param sfEvent $event
   * @static
   */
  public static function addRouteForAdminUser(sfEvent $event)
  {
    $event->getSubject()->prependRoute('sf_guard_user', new sfDoctrineRouteCollection(array(
      'name'                => 'sf_guard_user',
      'model'               => 'sfGuardUser',
      'module'              => 'sfGuardUser',
      'prefix_path'         => 'sf_guard_user',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  /**
   * Adds an sfDoctrineRouteCollection collection to manage groups.
   *
   * @param sfEvent $event
   * @static
   */
  public static function addRouteForAdminGroup(sfEvent $event)
  {
    $event->getSubject()->prependRoute('sf_guard_group', new sfDoctrineRouteCollection(array(
      'name'                => 'sf_guard_group',
      'model'               => 'sfGuardGroup',
      'module'              => 'sfGuardGroup',
      'prefix_path'         => 'sf_guard_group',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  /**
   * Adds an sfDoctrineRouteCollection collection to manage permissions.
   *
   * @param sfEvent $event
   * @static
   */
  public static function addRouteForAdminPermission(sfEvent $event)
  {
    $event->getSubject()->prependRoute('sf_guard_permission', new sfDoctrineRouteCollection(array(
      'name'                => 'sf_guard_permission',
      'model'               => 'sfGuardPermission',
      'module'              => 'sfGuardPermission',
      'prefix_path'         => 'sf_guard_permission',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }
}
