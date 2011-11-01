<?php

function js_append_inline($js, array $args = array()) {
  JSUtil::appendInline($js, $args);
}

function js_append_onready($js, array $args = array()) {
  JSUtil::appendOnReady($js, $args);
}

function dump_javascript() {
  echo JSUtil::dump();
}