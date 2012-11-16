<?php

class ua5GuardSecurityUser extends sfGuardSecurityUser
{

  public function addFlash($name, $value)
  {
    $data = $this->getFlash($name);
    if (!is_array($data)) {
      if (empty($data)) {
        $data = array();
      } else {
        $data = array($data);
      }
    }
    $data[] = $value;
    return $this->setFlash($name, $data);
  }

  /**
   * Get logged-in user ID without hitting the database
   */
  public function getGuardUserId($default = false)
  {
    return $this->getAttribute('user_id', $default, 'sfGuardSecurityUser');
  }
}
