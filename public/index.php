<?php
require_once(dirname(__FILE__, 2) . '/src/config/config.php');

define('PUBLIC_PATH', realpath(dirname(__FILE__)));

$uri = urldecode($_SERVER['REQUEST_URI']);

// $uri = str_replace('/public', '', $uri);
$uri = str_replace('/', '', $uri);
// $uri = str_replace('.php', '', $uri);

if ($uri === '/' || $uri === '' || $uri === 'index.php') {
    $uri = 'day_records';
}


$uri = explode('?', $uri);
$uri = $uri[0];

require_once(CONTROLLER_PATH . "/{$uri}.php");
