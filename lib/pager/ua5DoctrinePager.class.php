<?php

class ua5DoctrinePager extends sfDoctrinePager
{
  protected $queryCountFunction = null;

  public function getCountQuery()
  {
    if (isset(null !== $this->queryCountFunction)) {
      $query = $this->queryCountFunction;
    } else {
      $query = clone $this->getQuery();
    }

    $query
      ->offset(0)
      ->limit(0)
    ;

    return $query;
  }

  public function setCountQuery($query)
  {
    $this->queryCountFunction = $query;
  }
}
