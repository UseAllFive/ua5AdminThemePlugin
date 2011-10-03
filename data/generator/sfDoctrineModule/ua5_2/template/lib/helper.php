[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }
  
  public function linkToNew($params)
  {
    return sprintf(
      '<li class="sf_admin_action_new">%s</li>',
      link_to(
        '<span class="icon"></span>Add <?php echo ucfirst(sfInflector::humanize($this->getSingularName())) ?>',
        '@'.$this->getUrlForAction('new'),
        array('class' => 'r_3')
      )
    );
  }

  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to('<span class="icon"></span>'.__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return sprintf(
      '<li class="sf_admin_action_delete">%s</li>',
      link_to(
        '<span class="icon"></span>'.__($params['label'], array(), 'sf_admin'),
        $this->getUrlForAction('delete'), 
        $object, 
        array(
          'class' => 'r_3',
          'method' => 'delete',
          'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])
        )
    );
  }

  public function linkToList($params)
  {
    return sprintf(
      '<li class="sf_admin_action_list">%s</li>',
      link_to(
        '<span class="icon"></span>'.__($params['label'], array(), 'sf_admin'),
        '@'.$this->getUrlForAction('list'),
        array('class' => 'r_3')
      )
    );
  }

  public function linkToSave($object, $params)
  {
    return '<li class="sf_admin_action_save"><input type="submit" value="'. ($object->isNew() ? 'Save' : 'Update') .' <?php echo ucfirst(sfInflector::humanize($this->getSingularName())) ?>" class="r_3" /></li>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_save_and_add"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').' new <?php echo ucfirst(sfInflector::humanize($this->getSingularName())) ?>" name="_save_and_add" class="r_3 /></li>';    
  }
}
