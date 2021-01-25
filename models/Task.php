<?php


namespace testQ\Models;


class Task
{
    static function get(array $params)
    {
        global $db, $logger;
        $tasks = $db->select('tasks', ['[>]users' => ['user_id' => 'id']],
            [
                'tasks.id',
                'tasks.body',
                'tasks.state',
                'userData' => [
                    'users.username',
                ]
            ], $params);
//        if ($db->error()[2])
//        $logger->debug('', ['task' => $tasks, 'log' => $db->log()]);
        return $tasks;
    }

    static function update(array $params, $where)
    {
        global $db, $logger;
        $db->update('tasks', $params, $where);
        if ($db->error()[2]) {
            $logger->error('Update task failed', ['err' => $db->error()]);
            return false;
        }
        return true;
    }

    static function create(array $params)
    {
        global $db, $logger;
        $db->insert('tasks', $params);
        if ($db->error()[2])
            $logger->error('Create task failed', ['err' => $db->error()]);
        return $db->id();
    }

    static function count(array $params = [])
    {
        global $db;
        return $db->count('tasks', $params);
    }
}