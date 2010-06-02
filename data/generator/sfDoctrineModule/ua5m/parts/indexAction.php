  public function initialize($context, $moduleName, $actionName)
  {
    sfConfig::set('sf_app_template_dir', sfConfig::get("sf_plugins_dir").'/ua5AdminThemePlugin/templates');
    parent::initialize($context, $moduleName, $actionName);
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = false;
    $this->sort = false;
    $this->helper = false;    
<?php if (isset($this->params['with_doctrine_route']) && $this->params['with_doctrine_route']): ?>
    $this-><?php echo $this->getPluralName() ?> = $this->getRoute()->getObjects();
<?php else: ?>
    $this-><?php echo $this->getPluralName() ?> = Doctrine::getTable('<?php echo $this->getModelClass() ?>')
      ->createQuery('a')
      ->execute();
<?php endif; ?>
  }
