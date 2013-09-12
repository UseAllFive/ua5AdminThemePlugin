<?php

include dirname(__FILE__).'/../../bootstrap/unit.php';

$t = new lime_test();

class testUa5TesterResponse extends Ua5TesterResponse
{
  public static function testJsonKeyExists($json, $path, $delimiter = '.')
  {
    return self::jsonKeyExists($json, $path, $delimiter);
  }
}


$t->diag('Ua5TesterResponse');
$ua5TR = new testUa5TesterResponse(
  new sfTestBrowser(),
  $t
);

$json = '{"key": "val"}';
$json_decoded = json_decode($json, true);

$t->is(
  $ua5TR::testJsonKeyExists($json_decoded, 'key'),
  true,
  'jsonKeyExists with valid key'
);

$t->is(
  $ua5TR::testJsonKeyExists($json_decoded, 'bad_key'),
  false,
  'jsonKeyExists with invalid key'
);

$t->is(
  $ua5TR::testJsonKeyExists('Not JSON', 'SomePath'),
  false,
  'Testing with bad json'
);
