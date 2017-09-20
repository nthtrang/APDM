<?php

require_once('value.generic.percentage.php');

class ValueMinHeight extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueMinHeight);
  }

  function copy() {
    return parent::_copy(new ValueMinHeight);
  }
}

?>