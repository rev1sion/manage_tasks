<?php

namespace taskBj;


interface iDatabase
{
    public function __construct(array $db_auth);
}

interface iDbTasks
{
    public function getTasks(array $where);

    public function setTasks(array $data);

    public function deleteTasks(array $where);
}

interface iAdmin
{
    public function checkPerm($username);
}




