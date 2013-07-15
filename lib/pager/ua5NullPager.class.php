<?php

class ua5NullPager extends sfPager
{
  public function __construct($objects, $maxPerPage = 10)
  {
    if (! $objects instanceof Doctrine_Collection) {
      throw new InvalidArgumentException();
    }
    $this->objects = $objects;
    $this->nbResults = count($objects);
  }

  /**
   * Initialize the pager.
   *
   * Function to be called after parameters have been set.
   */
  public function init()
  {
  }

  /**
   * Returns an array of results on the given page.
   *
   * @return array
   */
  public function getResults()
  {
    return $this->objects;
  }

  /**
   * Returns an object at a certain offset.
   *
   * Used internally by {@link getCurrent()}.
   *
   * @return mixed
   */
  protected function retrieveObject($offset)
  {
    return $this->objects[$offset];
  }
}
