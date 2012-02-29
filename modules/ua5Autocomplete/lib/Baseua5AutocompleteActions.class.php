<?php

/**
 * ua5Autocomplete actions.
 *
 * @package    ua5_cms
 * @subpackage ua5Autocomplete
 * @author     Matt Farmer <matt@useallfive.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Baseua5AutocompleteActions extends sfActions {

  public function executeLookup(sfWebRequest $request) {

    $this->forward404Unless(
      ($model = $request->getParameter('model')) &&
      ($term = $request->getParameter('term')) &&
      ($table_method = $request->getParameter('table_method'))
    );
    $search_column = $request->getParameter('column', 'name');
    $id_column = $request->getParameter('value', 'id');

    $q = Doctrine_Core::getTable($model)->$table_method();
    $q->select("$id_column value, $search_column label");
    $q->andWhere("$search_column LIKE ?", "%$term%");
    $q->orderBy($search_column.' ASC');
    $q->limit(20);
    $rows = $q->fetchArray();

    $res = array(
//      'query' => $q->getSqlQuery(),
      'entries' => $rows,
    );

    return $this->renderJson($res);
  }

  public function renderJson($value) {
    self::setJsonResponseHeaders(sfContext::getInstance()->getResponse());

    return $this->renderText(json_encode($value));
  }

  static public function setJsonResponseHeaders(sfResponse $response) {
    $response->setContentType('application/json');

    // prevent response caching on client side
    $response->addCacheControlHttpHeader('no-cache, must-revalidate');
    $response->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');

    return $response;
  }


}
