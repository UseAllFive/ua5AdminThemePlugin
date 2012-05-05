<?php

abstract class ua5FormFilterDoctrine extends sfFormFilterDoctrine {


  protected function removeWithEmptyOption($field_names) {
    foreach ( $field_names as $field_name ) {
      $this->getWidget($field_name)
        ->setOption('with_empty', false);
    }
  }


}
