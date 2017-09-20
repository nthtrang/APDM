<?php

require_once('value.generic.percentage.php');

class ValueBottom extends CSSValuePercentage {
  function fromString($value) {
    return CSSValuePercentage::_fromString($value, new ValueBottom);
  }

  function copy() {
    return parent::_copy(new ValueBottom);
  }
}

?>