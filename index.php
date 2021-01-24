<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use taskBj\TaskController;

require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'models/models.php';


// connect logger
$log_dir = 'logs/' . date('Y') . "/" . date('m') . "/" . date('d');
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0775, true);
}
$stream = new StreamHandler($log_dir . '/tasks.log', Logger::DEBUG);
$logger = new Logger('index');
$logger->pushHandler($stream);
$logger->info('Initial log');


try {
    $database = new DatabaseConnection($dbAuth);
} catch (Exception $e) {
    $logger->error("Connect to db failed, {$e->getMessage()}", ['trace' => $e->getTrace()]);
    die();
}

$task = [];
$page = $_GET['page'] ?? 1;
$username = $_SESSION['username'] ?? null;

$controller = new TaskController($database);


$controller->get($username, $page);













