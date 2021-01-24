<?php

namespace taskBj;

use DatabaseConnection;

class TaskController
{
    private $db;

    public function __construct(DatabaseConnection &$db)
    {
        $this->db = $db;
    }


    public function post(array $data, $render = true, $id = null)
    {
        if ($render) {
            if ($id)
                require 'templates/task_update.html.php';
            else
                require 'templates/task_create.html.php';
        } else {
//              postNewTask
            if ($id)
                $this->updateTask($id, $data);
            else
                $this->createNewTask($data);
        }
    }

    public
    function get($username = null, $page = 1, $limit = 3, string $id = ''): void
    {
        if ($username)
            $is_admin = $this->db->checkPerm($username);

        if ($id) {
            $task = $this->db->getTasks(['id' => $id]);
            require 'templates/task_detail.html.php';
        } else {
            $tasks = $this->db->getTasks([], $page, $limit);
            require 'templates/task_list.html.php';
        }
    }

    function taskList($username = null, $page = 1, $limit = 3)
    {
        $tasks = $this->db->getTasks([], $page, $limit);
        if ($username)
            $is_admin = $this->db->checkPerm($username);

//        require 'templates/task_list.php';
    }

    public
    function createNewTask($data)
    {
        $this->db->setTasks($data);
    }

    public
    function updateTask($id, $data)
    {
        $this->db->setTasks($data, $id);
    }
}





