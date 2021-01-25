<?php


namespace testQ;


use testQ\Models\User;

class AuthController implements iRequestController
{

    static function handleRequest($action)
    {
        global $logger;
        if ($action == 'login' and @$_POST['username']) {
            $logger->debug('Login', ['cred' => $_POST]);

//            $pass = "password";
//            $hash = password_hash($pass, PASSWORD_BCRYPT, $options);

            $user = @User::get(['username' => $_POST['username']])[0];
            if ($user === false or empty($user)) {
                $logger->error('Auth user failed');
                $_SESSION['message'][] = 'Ошибка авторизации1';
                header('Location: /');
                exit();
            }
            $hash = (string)$user['pass'];
            if (password_verify($_POST['pass'], $hash)) {
                $logger->debug('Auth user', [$hash]);
                $_SESSION['username'] = 'admin';
                $_SESSION['message'][] = 'Success';
                header('Location: /');
            } else {
                $logger->error('Auth user failed', [$user]);
                $_SESSION['message'][] = 'Ошибка авторизации2';
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

    function validPass($pass)
    {

    }
}