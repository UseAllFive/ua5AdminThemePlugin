<?php

/**
 * work_item_credit actions.
 *
 * @package    methodstudios.com
 * @subpackage ua5Sort
 * @author     Matt Farmer <matt@useallfive.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class Baseua5SortActions extends sfActions {

  public function executeSort(sfWebRequest $request) {

    $this->forward404Unless(
      ($request->isMethod(sfRequest::POST)) &&
      ($model = sfInflector::classify($request->getParameter('model'))) &&
      ($items = $request->getParameter('order'))
    );

    foreach ( $items as $id => $positions ) {
      $obj = Doctrine_Core::getTable($model)->findOneById($id);
      if ( $obj ) {
        $obj->moveToPosition((int)$positions['new_position']);
      } else {
        return $this->renderText(json_encode(array(
          'status' => 'error',
          'errors' => array(
            sprintf('Could not find a "%s" with an ID of (%s)', $model, $id),
          ),
        )));
      }
    }

    return $this->renderText(json_encode(array(
      'status' => 'success',
    )));

  }


}
