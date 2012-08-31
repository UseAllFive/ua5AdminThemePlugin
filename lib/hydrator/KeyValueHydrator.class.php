<?php

/**
 * Populates an array, using the first column as the key and the second as the value.
 * Additional columns are ignored. Key column must be first, and value column must
 * be second.
 * 
 * @author Aaron Hall <adhall@gmail.com>
 */
class KeyValueHydrator extends Doctrine_Hydrator_Abstract {

  public function hydrateResultSet($stmt) {
    $result = array();

    while(($row = $stmt->fetch(PDO::FETCH_NUM)) !== false) {
      $result[$row[0]] = $row[1];
    }

    return $result;
  }
}