<?php

include dirname(__FILE__).'/../../bootstrap/unit.php';

$t = new lime_test();

class testUa5TesterResponse extends Ua5TesterResponse
{
  public static function testJsonKeyExists($json, $path, $delimiter = '.')
  {
    return self::jsonKeyExists($json, $path, $delimiter);
  }

  public static function testJsonKeyValue($json, $path, $delimiter = '.')
  {
    return self::jsonKeyValue($json, $path, $delimiter);
  }
}

$json = '{"key": "val"}';
$json_decoded = json_decode($json, true);

$ua5TR = new testUa5TesterResponse(
  new sfTestBrowser(),
  $t
);


$t->diag('Ua5TesterResponse');
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
  'jsonKeyExists with bad json'
);

$t->is(
  $ua5TR::testJsonKeyValue($json_decoded, 'key'),
  'val',
  'jsonKeyValue with valid key'
);

$outOfBoundsCaught = false;
try {
  $ua5TR::testJsonKeyValue($json_decoded, 'bad_key');
} catch (OutOfBoundsException $e) {
  $outOfBoundsCaught = true;
}
$t->is(
  $outOfBoundsCaught,
  true,
  'jsonKeyValue with invalid key'
);

/*
$t->is(
  $ua5TR->hasJsonKey('key'),
  true,
  'hasJsonKey with valid key'
);
 */
