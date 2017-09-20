<?php

require_once('value.generic.php');

class BorderColor extends CSSValue {
  var $left;
  var $right;
  var $top;
  var $bottom;

  function copy() {
    return new BorderColor($this->top, $this->right, $this->bottom, $this->left);
  }

  function BorderColor($top, $right, $bottom, $left) {
    $this->left   = $left->copy();
    $this->right  = $right->copy();
    $this->top    = $top->copy();
    $this->bottom = $bottom->copy();
  }
}

?>