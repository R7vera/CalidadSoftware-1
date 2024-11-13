<?php

session_start();

require_once 'routes/index.php';

$url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

Router::route(!empty($url[2]) ? $url[2] : 'login');

?>
