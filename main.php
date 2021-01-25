<?php

require_once 'vendor/autoload.php';
require_once 'config.php';


use Medoo\Medoo;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$tmp_dir = __DIR__ . '/tmp';
if (!file_exists($tmp_dir)) {
    mkdir($tmp_dir, 0777, true);
}

// Connect logger
$log_dir = 'logs/' . date('Y-m-d');
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0777, true);
}
$stream = new StreamHandler($log_dir . '/task.log', Logger::DEBUG);
$logger = new Logger('task');
$logger->pushHandler($stream);


try {
    $db = new Medoo($dbAuth);
} catch (Exception $e) {
    $logger->error("Connection lost", ['trace' => $e->getTrace()]);
}







