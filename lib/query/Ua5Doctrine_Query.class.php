<?php

class Ua5Doctrine_Query extends Doctrine_Query
{
  protected $joinedRelations = array();
  protected $relationNames = array();

  public function addRelation($name, $alias = null)
  {
    //-- Set Default alias to the lowercase of the first letter of the
    //   relation name
    if (null === $alias) {
      $alias = strtolower(substr($name, 0, 1));
    }

    //-- Make sure we don't already have an alias with this name
    $existingRelationName = array_search($alias, $this->relationNames);
    if (false !== $existingRelationName) {
      throw new InvalidArgumentException(
        sprintf(
          'Unable to add the "%s" relation with alias" %s".'."\n".
          'The "%s" relation is already configured with that alias.',
          $name,
          $alias,
          $existingRelationName
        )
      );
    }

    //-- Save the relation
    $this->relationNames[$name] = $alias;
  }

  public function withJoins($withRelations = array())
  {
    if (empty($withRelations)) {
      $withRelations = array_keys($this->relationNames);
    }

    $queryAlias = $this->getRootAlias();
    foreach ($withRelations as $relationName) {
      if (!isset($this->relationNames[$relationName])) {
        throw new InvalidArgumentException(
          sprintf(
            'Invalid relation name "%s" passed to %s::%s.',
            $relationName,
            __CLASS__,
            __METHOD__
          )
        );
      }
      if (!in_array($relationName, $this->joinedRelations)) {
        $relationAlias = $this->relationNames[$relationName];
        $this->leftJoin("$queryAlias.$relationName $relationAlias");
        $this->joinedRelations[] = $relationName;
      }
    }

    return $this;
  }
}
