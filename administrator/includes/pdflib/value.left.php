<?php

require_once('value.generic.percentage.php');

class ValueLeft extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueLeft);
  }

  function copy() {
    return parent::_copy(new ValueLeft);
  }
}

?>