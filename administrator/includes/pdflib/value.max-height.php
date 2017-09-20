<?php

require_once('value.generic.percentage.php');

class ValueMaxHeight extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueMaxHeight);
  }

  function copy() {
    return parent::_copy(new ValueMaxHeight);
  }
}

?>