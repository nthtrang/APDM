<?php
// $Header: /cvsroot/html2ps/css.top.inc.php,v 1.13 2006/09/07 18:38:14 Konstantin Exp $

require_once(HTML2PS_DIR.'/value.top.php');

class CSSTop extends CSSPropertyHandler {
  function CSSTop() { 
    $this->CSSPropertyHandler(false, false); 
    $this->_autoValue = ValueTop::fromString('auto');
  }

  function _getAutoValue() {
    return $this->_autoValue->copy();
  }

  function default_value() { 
    return $this->_getAutoValue();
  }

  function getPropertyCode() {
    return CSS_TOP;
  }

  function getPropertyName() {
    return 'top';
  }

  function parse($value) { 
    return ValueTop::fromString($value);
  }
}

CSS::register_css_property(new CSSTop);

?>