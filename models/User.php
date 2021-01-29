<?php

namespace testQ\Models;


class User
{

    /**
     * @param array $params
     * @param string|array $fields
     * @return array|bool
     */
    static function get(array $params, $fields = '*')
    {
        global $db;
        return $db->select('users', $fields, $params);
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