  protected function getModelSort($modelName)
  {
    $usModelName = sfInflector::underscore($modelName);
    $sort = $this->getUser()->getAttribute("$modelName.sort", null, 'admin_module');
    if (null !== $sort) {
      return $sort;
    }

    $configName = $modelName.'Configuration';
    $configGeneratorName = $usModelName.'GeneratorConfiguration';
    $this->$configName = new $configGeneratorName();
    $this->setModelSort($modelName, $this->$configName->getDefaultSort());

    return $this->getUser()->getAttribute("$usModelName.sort", null, 'admin_module');
  }

  protected function setModelSort($modelName, array $sort)
  {
    $usModelName = sfInflector::underscore($modelName);
    if (null !== $sort[0] && null === $sort[1])
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute("$usModelName.sort", $sort, 'admin_module');
  }

  protected $ignoredAlias = array();
  protected function getRelatedDependencies($obj) {
    $relations = $obj->getTable()->getRelations();
    foreach ($relations as $alias => $relation) {
      if (
        Doctrine_Relation::MANY !== $relation['type'] ||
        in_array($alias, $this->ignoredAlias)
      ) {
        continue;
      }
      $modelName = $relation['class'];
      $lcModelName = lcfirst($relation['class']);
      $usModelName = sfInflector::underscore($modelName);
      $pagerName = $lcModelName.'Pager';
      $sortName = $lcModelName.'Sort';
      $helperName = $lcModelName.'Helper';
      $generatorHelperName = $usModelName.'GeneratorHelper';
      $getterName = "get$alias";
      $this->$pagerName = new ua5NullPager($obj->$getterName());
      $this->$sortName = $this->getModelSort($modelName);
      $this->$helperName = new $generatorHelperName();
    }
  }

