<?php

require_once('value.generic.percentage.php');

class ValueHeight extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueHeight);
  }

  function copy() {
    return parent::_copy(new ValueHeight);
  }
}

?>