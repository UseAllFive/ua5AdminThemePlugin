<?php

class Ua5TesterResponse extends sfTesterResponse
{
  public function isEqual($val1, $val2, $message)
  {
    $this->tester->is(
      $val1,
      $val2,
      sprintf('Value is "%s, expected %s. %s"', $val1, $val2, $message)
    );
    return $this->getObjectToReturn();
  }

  protected static function jsonKeyExists($json, $path, $delimiter = '.')
  {
    $has = false;
    if (!is_array($path)) {
      $path = explode($delimiter, $path);
    }
    foreach ($path as $key) {
      $has = array_key_exists($key, $json);
      if ($has) {
        $json = $json[$key];
      }
    }
    return $has;
  }

  protected static function jsonKeyValue($json, $path, $delimiter = '.')
  {
    if (!is_array($path)) {
      $path = explode($delimiter, $path);
    }
    foreach ($path as $key) {
      $has = array_key_exists($key, $json);
      if ($has) {
        $json = $json[$key];
      } else {
        throw new OutOfBoundsException();
      }
    }
    return $json;
  }

  protected function getJson()
  {
    return json_decode($this->response->getContent(), true);
  }

  public function hasJsonKey($path)
  {
    $json = $this->getJson();
    if (!self::jsonKeyExists($json, $path)) {
      $this->tester->fail(sprintf('Key (%s) not found in json response', $path));
    } else {
      $this->tester->pass(sprintf('Key (%s) found in json response', $path));
    }
    return $this->getObjectToReturn();
  }

  public function hasJsonKeyValue($path, $value)
  {
    $json = $this->getJson();
    try {
      $have = self::jsonKeyValue($json, $path);
      if (false === $have || $have !== $value) {
        $this->tester->fail(
          sprintf('Expected (%s) but found (%s) for path (%s) in json response', $value, $have, $path)
        );
      } else {
        $this->tester->pass(
          sprintf(
            'Found expected value (%s) for path (%s) in json response',
            $value,
            $path
          )
        );
      }
    } catch (OutOfBoundsException $e) {
      $this->tester->fail(sprintf('Invalid path (%s) tested in json response. %s', $path, $e->getMessage()));
    }
    return $this->getObjectToReturn();
  }

  public function isContentType($content_type)
  {
    $want = strtolower($content_type);
    $have = strtolower($this->response->getContentType());
    if ($want == $have) {
      $this->tester->pass(sprintf('Content Type "%s" matches "%s"', $have, $want));
    } else {
      $this->tester->fail(sprintf('Content Type "%s" does not match "%s"', $have, $want));
    }
    return $this->getObjectToReturn();
  }

  /**
   * Tests to see if the type is JSON
   *
   * @return sfTestFunctionalBase|sfTester
   */
  public function isJson()
  {
    $this->isContentType('application/json');

    $this->tester->isnt(
      json_decode($this->response->getContent()),
      null,
      'Able to decode JSON document.'
    );

    return $this->getObjectToReturn();
  }

  public function isCount($expectedCount, $arr)
  {
    $actualCount = count($arr);
    $this->tester->is(
      $actualCount,
      $expectedCount,
      sprintf('JSON count is "%s, expected %s"', $actualCount, $expectedCount)
    );

    return $this->getObjectToReturn();
  }
}
