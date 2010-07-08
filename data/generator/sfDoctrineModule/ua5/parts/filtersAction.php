  protected function getFilters()
  {
    if (isset($this->overridden_filters))
    {  
      return $this->overridden_filters;
    }else
    {
      $filter_array = $this->getUser()->getAttribute('<?php echo $this->getModuleName() ?>.filters', $this->configuration->getFilterDefaults(), 'admin_module');
    }
    return $filter_array;
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('<?php echo $this->getModuleName() ?>.filters', $filters, 'admin_module');
  }