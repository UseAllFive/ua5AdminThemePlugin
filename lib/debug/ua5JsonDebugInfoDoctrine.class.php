<?php

class ua5JsonDebugInfoDoctrine {


  /**
   * Returns an array of Doctrine query events.
   * 
   * @return array
   */
  protected function getDoctrineEvents() {
    $databaseManager = sfContext::getInstance()->getDatabaseManager();

    $events = array();
    if ($databaseManager) {
      foreach ($databaseManager->getNames() as $name) {
        $database = $databaseManager->getDatabase($name);
        if ($database instanceof sfDoctrineDatabase && $profiler = $database->getProfiler()) {
          foreach ($profiler->getQueryExecutionEvents() as $event) {
            $events[$event->getSequence()] = $event;
          }
        }
      }
    }

    // sequence events
    ksort($events);

    return $events;
  }


  /**
   * Builds the sql logs and returns them as an array.
   *
   * @return array
   */
  protected function getSqlLog() {
    $log = array();
    foreach ($this->getDoctrineEvents() as $i => $event) {
      $params = sfDoctrineConnectionProfiler::fixParams($event->getParams());
      $query = $event->getQuery();

      // interpolate parameters
      foreach ($params as $param) {
        $query = join(var_export(is_scalar($param) ? $param : (string) $param, true), explode('?', $query, 2));
      }

      $log[] = array(
        ($event->slowQuery ? 'QUERY' : 'query') => $query,
        'time' => number_format($event->getElapsedSecs(), 2),
      );
    }
    return $log;
  }


  public function jsonSerialize() {
    $events = $this->getDoctrineEvents();
    return array(
      'doctrine' => array(
        'version' => Doctrine_Core::VERSION,
        'query_count' => count($events),
        'log' => $this->getSqlLog(),
      ),
    );
  }


}
