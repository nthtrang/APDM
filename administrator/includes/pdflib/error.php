<?php

function error_no_method($method, $class) {
  die(sprintf("Error: unoverridden '%s' method called in '%s'", $method, $class));
}

?>