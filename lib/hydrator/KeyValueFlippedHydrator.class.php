<?php

/**
 * Populates an array, using the second column as the key and the first as the value.
 * Additional columns are ignored. Key column must be second, and value column must
 * be first.
 * 
 * This is exactly the same as KeyValueHydrator, except the key/value is flipped, because
 * Doctrine_Query doesn't predictably order columns in the PDO result.
 * 
 * @author Aaron Hall <adhall@gmail.com>
 */
class KeyValueFlippedHydrator extends Doctrine_Hydrator_Abstract {

  public function hydrateResultSet($stmt) {
    $result = array();

    while(($row = $stmt->fetch(PDO::FETCH_NUM)) !== false) {
      $result[$row[1]] = $row[0];
    }

    return $result;
  }
}