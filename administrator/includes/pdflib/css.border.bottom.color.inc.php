<?php
// $Header: /cvsroot/html2ps/css.border.bottom.color.inc.php,v 1.1 2006/09/07 18:38:13 Konstantin Exp $

class CSSBorderBottomColor extends CSSSubProperty {
  function CSSBorderBottomColor(&$owner) {
    $this->CSSSubProperty($owner);
  }

  function setValue(&$owner_value, &$value) {
    $owner_value->bottom->setColor($value);
  }

  function getValue(&$owner_value) {
    return $owner_value->bottom->color->copy();
  }

  function getPropertyCode() {
    return CSS_BORDER_BOTTOM_COLOR;
  }

  function getPropertyName() {
    return 'border-bottom-color';
  }

  function parse($value) {
    if ($value == 'inherit') {
      return CSS_PROPERTY_INHERIT;
    }

    return parse_color_declaration($value);
  }
}

?>