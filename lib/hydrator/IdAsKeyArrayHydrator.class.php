<?php

/**
 * Populates an array, using the named 'id' column as the key and remaining as a
 * column => value pairs as a second-dimension array.
 * 
 * @author Aaron Hall <adhall@gmail.com>
 */
class IdAsKeyArrayHydrator extends Doctrine_Hydrator_ArrayDriver {

  public function hydrateResultSet($stmt) {
    $result = array();
    
    $hydrated = parent::hydrateResultSet($stmt);
    
    foreach($hydrated as $row) {
      $id = $row['id'];
      unset($row['id']);
      $result[$id] = array();
      
      foreach($row as $key => $val) {
        $result[$id][$key] = $val;
      }
    }
    
    return $result;
  }
}