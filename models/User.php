<?php

namespace testQ\Models;


class User
{

    static function get(array $params)
    {
        global $db;
        return $db->select('users', '*', $params);
    }

    static function create(array $params)
    {
        global $db, $logger;
        $db->insert('users', $params);
        if ($db->error()[2]) {
            $logger->error('Create user failed', ['err' => $db->error()]);
        }
        return $db->id();
    }

    static function isAdmin($username)
    {
        global $db;
        return $db->get('users', 'admin', ['username' => $username]);
    }
}