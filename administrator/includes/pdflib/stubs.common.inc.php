<?php
// $Header: /cvsroot/html2ps/stubs.common.inc.php,v 1.4 2006/09/07 18:38:16 Konstantin Exp $

if (!function_exists('file_get_contents')) {
  require_once('stubs.file_get_contents.inc.php');
}

if (!function_exists('file_put_contents')) {
  require_once('stubs.file_put_contents.inc.php');
}

if (!function_exists('is_executable')) {
  require_once('stubs.is_executable.inc.php');
}

if (!function_exists('memory_get_usage')) {
  require_once('stubs.memory_get_usage.inc.php');
}

?>