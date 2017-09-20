<?php

require_once('filter.data.encoding.class.php');

class DataFilterUTF8 extends DataFilterEncoding {
  function _convert(&$data, $encoding) {
    $converter = Converter::create();
    $data->set_content($converter->to_utf8($data->get_content(), $encoding));
  }
}

?>