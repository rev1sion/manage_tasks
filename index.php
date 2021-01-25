<?php

use testQ\Models\User;

require_once "main.php";

ini_set('display_errors', true);


session_start();
$logger->debug('Session', ['sss' => $_SESSION]);
$logger->debug('init', ['post' => $_POST, 'get' => $_GET]);

if (!empty($_SESSION['message'])) {
    foreach ($_SESSION['message'] as $value) {
        echo <<<MESSAGE
<div>{$value}</div>   
MESSAGE;
    }
    unset($_SESSION['message']);
}
echo $_SESSION['username'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (isset($_GET['auth'])) {
    \testQ\AuthController::handleRequest($_GET['auth']);
} else {
    \testQ\TaskController::handleRequest($_GET['task']);
}











