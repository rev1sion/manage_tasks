<?php


namespace testQ;


use testQ\Models\User;

class AuthController implements iRequestController
{

    static function handleRequest($action)
    {
        global $logger;
        if ($action === 'login' and $username = $_POST['username']) {
            $logger->debug('Login', ['cred' => $_POST]);

            // Used PDO driver. if u want we can use $username = mysql_real_escape_string($username);
            $user_pass = @User::get(['username' => $username], 'pass')[0];
            if ($user_pass === false or empty($user_pass)) {
                $logger->error('Auth user failed');
                $_SESSION['message'][] = 'Ошибка авторизации';
                header('Location: /');
                exit();
            }
            $hash = (string)$user_pass;
            if (password_verify($_POST['pass'], $hash)) {
                $logger->debug('Auth user', [$hash]);
                $_SESSION['username'] = 'admin';
                $_SESSION['message'][] = "Hello $username";
                header('Location: /');
            } else {
                $logger->error('Auth user failed: invalid password', [$user_pass]);
                $_SESSION['message'][] = 'Ошибка авторизации';
                header('Location: /');
            }
        } elseif ($action == 'logout') {
            $logger->debug('logout', ['cred' => $_POST]);
            unset($_SESSION['username']);
            header('Location: /');
        } else {
            $_SESSION['message'][] = 'Ошибка авторизации';
            header('Location: /');
            exit;
        }
    }
}