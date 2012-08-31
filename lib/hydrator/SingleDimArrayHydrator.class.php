<?php

/**
 * Just like Doctrine_Hydrator_SingleScalarDriver, except it always returns an array
 * even when there is one record.
 *
 * @author Aaron Hall <adhall@gmail.com>
 */
class SingleDimArrayHydrator extends Doctrine_Hydrator_Abstract {

  public function hydrateResultSet($stmt) {
    $result = array();
    while(($val = $stmt->fetchColumn()) !== false) {
      $result[] = $val;
    }

    return $result;
  }

}