<?php

class Ua5Doctrine_Query extends Doctrine_Query
{
  protected $joinedRelations = array();
  protected $relationNames = array();

  /**
   * Configure an available relation
   * @param string $name The name of the relation as defined in the key in the schema.yml file
   * @param (string|array) $options (string) the alias to be used in the join statement
   *                                (null|empty array()) the first letter of the relation name will be used as the alias
   *                                (array) available keys:
   *                                    'alias': The alias to be used in the join statement
   *                                    other: a key value list of method to call and an array of values to be passed to that method
   *        Example:  array(
   *                      'alias' => 't',
   *                      'addOrderBy' => array(
   *                          't.position',
   *                          'DESC',
   *                      )
   *                  )
   */
  public function addRelation($name, $options = array())
  {
    if (is_string($options)) {
      $options = array(
        'alias' => $options,
      );
    }

    //-- Set Default alias to the lowercase of the first letter of the
    //   relation name
    if (!isset($options['alias'])) {
      $options['alias'] = strtolower(substr($name, 0, 1));
    }

    //-- Make sure we don't already have an alias with this name
    foreach ($this->relationNames as $relationName => $relationOptions) {
      if ($options['alias'] === $relationOptions['alias']) {
        throw new InvalidArgumentException(
          sprintf(
            'Unable to add the "%s" relation with alias" %s".'."\n".
            'The "%s" relation is already configured with that alias.',
            $name,
            $options['alias'],
            $relationName
          )
        );
      }
    }

    //-- Save the relation
    $this->relationNames[$name] = $options;
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
        $relationOptions = $this->relationNames[$relationName];
        foreach ($relationOptions as $func => $params) {
          if ('alias' === $func) {
            $relationAlias = $params;
            $this->leftJoin("$queryAlias.$relationName $relationAlias");
          } else {
            call_user_func_array(array($this, $func), $params);
          }
        }
        $this->joinedRelations[] = $relationName;
      }
    }

    return $this;
  }
}
