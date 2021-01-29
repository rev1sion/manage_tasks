<?php


namespace testQ;


use testQ\Models\Task;
use testQ\Models\User;

class TaskController implements iRequestController
{
    static function handleRequest($action)
    {
        global $logger;
        $logger->debug('task controller', ['post' => $_POST, 'get' => $_GET]);
        $def_order_by = ['created_at', 'DESC'];

        switch ($action) {
            case 'create':
                $username = $_POST['username'] ?? $_SESSION['username'];
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $logger->error('Email validation failed', ['em' => $email]);
                    $_SESSION['message'][] = 'Email is not valid';
                    header('Location: /');
                }

                $user_id = @User::get(['username' => $username], 'id')[0];
                if (empty($user_id)) {
                    $user = [
                        'username' => $username,
                        'email' => $email,
                        'ip_address' => '123'
                    ];
                    $user_id = User::create((array)$user);
                    $logger->debug('Create user', ['user' => $user]);
                }

                // CREATE TASK
                $task = [
                    'user_id' => $user_id,
                    'body' => $_POST['body'],
                ];

                if (isset($_POST['state']))
                    $task['state'] = $_POST['state'];

                $_task = Task::create($task);

                if ($task === false or empty($_task)) {
                    $logger->error('Create task failed', ['task' => $task]);
                    $_SESSION['message'][] = 'Create task failed';
                } else {
                    $logger->debug('Created task', ['task' => $_task]);
                    $_SESSION['message'][] = 'Create task success';
                }
                //                $this->notify();
                header('Location: /');
                break;
            case 'update':
                if (isset($_SESSION['username'])) {
                    $is_admin = @User::get(['username' => $_SESSION['username']], 'admin')[0];
                    if ($is_admin) {
                        $params = [
                            'body' => $_POST['body'],
                            'state' => $_POST['state'],
                        ];

                        if (isset($_POST['username'])) {
                            $_user = @User::get(['username' => $_POST['username']], ['id', 'username'])[0];
                            $params['user_id'] = $_user['id'];
                        }

                        $update = Task::update($params, ['id' => filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT)]);

                        if ($update) $_SESSION['message'][] = 'Update task success';
                        else $_SESSION['message'][] = 'Update task failed';
                    } else {
                        $_SESSION['message'][] = 'Permission denied';
                    }
                    header('Location: /');

                } else {
                    header("Location: index.php?auth=login");
                }
                break;
            case 'sort':
                $sort = filter_input(INPUT_GET, 'by', FILTER_SANITIZE_STRING);
                list($sort, $value) = explode(':', $sort);
                if (stripos($sort, 'name') !== false) {
                    if ($value === 'DESC') {
                        $def_order_by = ['users.username', 'ASC'];
                    } elseif ($value === 'ASC') {
                        $def_order_by = ['users.username', 'DESC'];
                    }
                } elseif (stripos($sort, 'date') !== false){
                    if ($value === 'DESC') {
                        $def_order_by = ['created_at', 'ASC'];
                    }
                }
            default:
                if (isset($_SESSION['username']))
                    $is_admin = true;
                else
                    $is_admin = false;

                $page = $_GET['page'] ?? 1;
                $limit = 3;
                $offset = ($page - 1) * $limit;
                $tasks = Task::get([
                    'ORDER' => [$def_order_by[0] => $def_order_by[1]],
                    'LIMIT' => [$offset, $limit]
                ]);

                $count = Task::count();
                $last_page = ceil($count / $limit);
                if (Task::count() > $limit) {
                    if ($page < $last_page)
                        $next_page = $page + 1;
                    if ($page > 1)
                        $prev_page = $page - 1;
                }
                include 'templates/task_list.html.php';
                break;
        }
    }
}