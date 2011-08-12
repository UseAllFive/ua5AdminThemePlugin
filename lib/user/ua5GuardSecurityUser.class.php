<?php

class ua5GuardSecurityUser extends sfGuardSecurityUser {

  public function addFlash($name, $value) {
    $data = $this->getFlash($name);
    if ( !is_array($data) ) {
      if ( empty($data) ) {
        $data = array();
      } else {
        $data = array($data);
      }
    }
    $data[] = $value;
    return $this->setFlash($name, $data);
  }

}
