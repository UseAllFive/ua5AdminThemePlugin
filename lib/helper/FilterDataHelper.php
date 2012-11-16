<?php

function filter_has_data($attribute_name, $form)
{
  $expand_filter = false;
  $filters = false;
  if (sfContext::getInstance()->has($attribute_name)) {
    $filters = false;
  } else {
    $filters = sfContext::getInstance()->getUser()->getAttribute($attribute_name, false, 'admin_module');
  }

  if (false != $filters) {
    foreach ($filters as $key => $value) {
      if (!$value) {
        unset($filters[$key]);
      } elseif (is_array($value)) {
        //If have text key exists and is_empty does not exists (sfWidgetFormInput)
        if (array_key_exists('text', $value) && !$value['text'] && !array_key_exists('is_empty', $value)) {
          unset($filters[$key]);
        } elseif (array_key_exists('text', $value) && !$value['text'] && !array_key_exists('is_empty', $value) && !$value['is_empty']) {
          //If have text and is_empty keys exists (sfWidgetFormInput)
          unset($filters[$key]);
        } elseif (array_key_exists('from', $value) && array_key_exists('to', $value) && !$value['from'] && !$value['to']) {
          //sfWidgetFormDate
          unset($filters[$key]);
        }

      }

    }

    if (0 != count($filters)) {
      $expand_filter = true;
    }
  }
  return $expand_filter;
}
