<?php


namespace testQ;


class IndexController implements iRequestController
{
    static function handleRequest(string $action)
    {
        if (isset($_GET['auth'])) {
            AuthController::handleRequest($_GET['auth']);
        } else {
            TaskController::handleRequest($_GET['task']);
        }
    }
}