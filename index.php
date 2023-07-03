<?php

/* SAINDO DA PASTA SPLASH */
if (strtolower(trim($_SERVER["HTTP_HOST"])) === 'localhost'){
  $folderPai = pathinfo( dirname ( dirname (__file__) ) );
  
  $url = "http://localhost/git/__DOM__/" . $folderPai["basename"] . "/";
}else
  $url = "http://" . strtolower(trim($_SERVER["HTTP_HOST"])) . "/";

if (preg_match('/^(.*)?\/splash(\/.*)?$/', $_SERVER["REQUEST_URI"]))
  header("location: $url");
  
# INCLUINDO O HTML DO PROJETO
require_once dirname(__FILE__) . "/projeto.php";

?>