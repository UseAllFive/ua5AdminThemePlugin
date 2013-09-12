<?php

if (!isset($_SERVER['SYMFONY']))
{
  throw new RuntimeException('Could not find symfony core libraries.');
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

$configuration = new sfProjectConfiguration(dirname(__FILE__).'/../fixtures/project');
require_once $configuration->getSymfonyLibDir().'/vendor/lime/lime.php';

require_once dirname(__FILE__).'/../../../sfTaskExtraPlugin/config/sfTaskExtraPluginConfiguration.class.php';
$plugin_configuration = new sfTaskExtraPluginConfiguration($configuration, dirname(__FILE__).'/../..');
