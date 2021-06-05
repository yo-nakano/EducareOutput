<?php
  define ('ROOT_PATH', str_replace('public', '', $_SERVER["DOCUMENT_ROOT"]));
  $parse = parse_url($_SERVER["REQUEST_URI"]);
  // ファイル名が省略されていた場合、index.phpを補填
  if(mb_substr($parse['path'], -1) === '/') {
    $parse['path'] .= $SERVER["SCRIPT_NAME"];
  }
  require_once(ROOT_PATH.'Views'.$parse['path']);
?>