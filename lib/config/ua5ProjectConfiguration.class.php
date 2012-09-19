<?php

class ua5ProjectConfiguration extends sfProjectConfiguration {


  protected static
    $routing = array();


  /**
   * Returns the routing resource for the active application
   */
  static public function getRouting($force_new = false, $app_name = null, $env = 'prod', $is_secure = null) {

    //-- Save our original settings so we can put them back at the end if needed
    $orig_app = sfConfig::get('sf_app');
    $orig_env = sfConfig::get('sf_environment');
    $orig_debug = sfConfig::get('sf_debug');

    //-- Set Defaults
    if ( null === $app_name ) {
      $app_name = sfConfig::get('sf_app');
    }
    if ( null === $is_secure ) {
      $is_secure = sfConfig::get('app_is_secure', false);
    }

    $key = sprintf(
      '%s_%s_%s',
      $app_name,
      $env,
      $is_secure ? 'secure' : 'insecure'
    );

    $orig_key = sprintf(
      '%s_%s_%s',
      $orig_app,
      $orig_env,
      array_key_exists('HTTPS', $_SERVER) ? 'secure' : 'insecure'
    );

    //-- Check if they:
    //   1) want to use the crrent route
    //   2) its the same app
    //   3) and we have a route loaded
    if (
      !$force_new &&
      $key === $orig_key &&
      sfContext::hasInstance() &&
      (self::$routing[$key] = sfContext::getInstance()->getRouting())
    ) {
      return self::$routing[$key];
    }

    if ( $force_new || !array_key_exists($key, self::$routing) ) {
      // Initialization
      if (!self::hasActive()) {
        throw new sfException('No sfApplicationConfiguration loaded');
      }

      $appConfig = self::getApplicationConfiguration($app_name, $env, false);
      $config = sfFactoryConfigHandler::getConfiguration($appConfig->getConfigPaths('config/factories.yml'));

      if ( sfConfig::get('sf_no_script_name') ) {
        $default_prefix = '';
      } else {
        $default_prefix = sprintf(
          '/%s%s.php',
          $appConfig->getApplication(),
          ('prod' === $appConfig->getEnvironment() ? '' : '_'. $appConfig->getEnvironment())
        );
      }

      $params = array_merge(
        $config['routing']['param'],
        array(
          'load_configuration' => false,
          'logging'            => false,
          'context'            => array(
            'host'      => sfConfig::get('app_host', 'localhost'),
            'prefix'    => sfConfig::get('app_prefix', $default_prefix),
            'is_secure' => $is_secure,
          ),
        )
      );

      $handler = new sfRoutingConfigHandler();
      $routes = $handler->evaluate($appConfig->getConfigPaths('config/routing.yml'));
      $routeClass = $config['routing']['class'];
      self::$routing[$key] = new $routeClass($appConfig->getEventDispatcher(), null, $params);
      self::$routing[$key]->setRoutes($routes);

      //-- Restore original settings
      self::getApplicationConfiguration($orig_app, $orig_env, $orig_debug);
    }
    return self::$routing[$key];
  }


}
