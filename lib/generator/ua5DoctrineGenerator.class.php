<?php

/**
 * ua5Doctrine generator.
 *
 * @package    symfony
 * @subpackage doctrine
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfDoctrineGenerator.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ua5DoctrineGenerator extends sfDoctrineGenerator {

  /**
   * Returns an array of tables that represents a one to many relationship.
   *
   * @return array An array of tables.
   */
  public function getOneToManyTables() {
    $relations = array();
    foreach ($this->table->getRelations() as $relation) {
      if (
        $relation->getType() === Doctrine_Relation::MANY &&
        !isset($relation['refTable']) &&
        !$relation->isRefClass()
      ) {
          $relations[] = $relation;
      }
    }
    return $relations;
  }


  /**
   * Returns HTML code for an action link.
   *
   * @param string  $actionName The action name
   * @param array   $params     The parameters
   * @param boolean $pk_link    Whether to add a primary key link or not
   *
   * @return string HTML code
   *
   */
  public function getLinkToAction($actionName, $params, $pk_link = false)  {


    if ( isset($params['doctrine_route']) ) {
      /*
       * Allow the following in generator.yml:
       *
       *     object_actions:
       *       show:
       *         doctrine_route: 'screenshot_show'
       *
       */
      $route = $params['doctrine_route'];
      $link_to_params = '$'.$this->getSingularName();
   } else {
      /*
       * Allow the following in generator.yml:
       *
       *     object_actions:
       *       show:
       *         route: 'screenshot_show'
       *         url_params:
       *           my_key: 'my_val'
       *           second_key: '@sf_request'  #-- Replace with $sf_request->getParamter('second_key')
       *
       */
      $action = isset($params['action']) ? $params['action'] : 'List'.sfInflector::camelize($actionName);
      $route = sprintf(
        "'%s'",
        isset($params['route']) ? $params['route'] : $this->getModuleName().'/'.$action
      );

      if ( $pk_link ) {
        $url_params = ".'?".$this->getPrimaryKeyUrlParams();
      }
      if ( isset($params['url_params']) && is_array($params['url_params']) ) {
        foreach ( $params['url_params'] as $k => $v ) {
          if ( '@sf_request' === $v ) {
            $url_params.= '. \'&'. urlencode($k) .'=\'. urlencode(sfContext::getInstance()->getRequest()->getParameter(\''. $k .'\'))';
          } else {
            $url_params.= '. \'&'. http_build_query(array($k => $v));
          }
        }
      }
      $route.=$url_params;
      $link_to_params = $this->asPhp($params['params']);
    }

    return sprintf(
      '[?php echo link_to(__(\'%s\', array(), \'%s\'), %s, %s) ?]',
      $params['label'],
      $this->getI18nCatalogue(),
      $route,
      $link_to_params
    );
  }


}
