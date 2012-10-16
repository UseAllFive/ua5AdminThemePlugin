<?php

class ua5JsonDebugInfoMemory {


  public function jsonSerialize() {
    return array(
      'memory' => array(
        'usage' => sprintf('%.1f', (memory_get_peak_usage(true))),
        'units' => 'bytes',
      ),
    );
  }


}
