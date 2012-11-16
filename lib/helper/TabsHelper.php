<?php

function set_active_tab($active_tab)
{
  sfContext::getInstance()->set("active_tab", $active_tab);
}
