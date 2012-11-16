<?php

/**
 * Just like Doctrine_Hydrator_SingleScalarDriver, except it always returns an array
 * even when there is one record and casts all values to ints
 *
 * @author Aaron Hall <adhall@gmail.com>
 */
class SingleDimIntegerArrayHydrator extends Doctrine_Hydrator_Abstract
{

  public function hydrateResultSet($stmt)
  {
    $result = array();
    while (($val = $stmt->fetchColumn()) !== false) {
      $result[] = (int)$val;
    }

    return $result;
  }
}
