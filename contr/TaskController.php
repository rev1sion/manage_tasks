<?php


namespace testQ;


use testQ\Models\Task;
use testQ\Models\User;

class TaskController implements iRequestController
{
    static function handleRequest($action)
    {
        global $logger;
        $logger->debug('task controller', ['post' => $_POST]);

        switch ($action) {
            case 'create':
                //... validate
//                $user = new User();
//                $user->username = $_POST['username'] ?? $_SESSION['username'];
//                $user->email = $_POST['email'];
//                $user->ip = '123';

                $user_id = @User::get(['username' => $_POST['username'] ?? $_SESSION['username']])[0]['id'];
                if (empty($user_id)) {
                    $user = [
                        'username' => $_POST['username'] ?? $_SESSION['username'],
                        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
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
                if (@$_SESSION['username']) {
                    $user = @User::get(['username' => $_SESSION['username']])[0];
                    if ($user['admin']) {
                        $params = [
                            'body' => $_POST['body'],
                            'state' => $_POST['state'],
                        ];

                        if (@$_POST['username']) {
                            $_user = @User::get(['username' => $_POST['username']])[0];
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
            case 'edit':
                if (!empty($_SESSION['username'])) {
                    // ... check admin

                    $is_admin = true;
                    $task = @Task::get(['tasks.id' => filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)])[0];
                    $users = @User::get(['LIMIT' => [0, 5]]);
                    include_once 'templates/task_edit.html.php';
                }
                break;
            default:

                if (@$_SESSION['username'])
                    $is_admin = true;
                else
                    $is_admin = false;

                $page = $_GET['page'] ?? 1;
                $limit = 3;
                $offset = ($page - 1) * $limit;
                $tasks = Task::get([
                    'ORDER' => ['created_at' => 'DESC'],
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