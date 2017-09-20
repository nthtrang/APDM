<?php

require_once('value.generic.percentage.php');

class ValueRight extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueRight);
  }

  function copy() {
    return parent::_copy(new ValueRight);
  }
}

?>