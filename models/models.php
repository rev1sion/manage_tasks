<?php


use Medoo\Medoo;
use taskBj\iAdmin;
use taskBj\iDatabase;
use taskBj\iDbTasks;


class DatabaseConnection implements iDatabase, iDbTasks, iAdmin
{
    private Medoo $connection;

    public function __construct(array $db_auth)
    {
        $this->connection = new Medoo($db_auth);
    }

    /**
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array|bool
     */
    public function getTasks(array $where = [], $page = 1, $limit = 3)
    {
        if (!empty($where['id'])) {
            $t = $this->connection->get('tasks', ['[>]users' => ['user_id' => 'id']], '*', ['tasks.id' => $where['id']]);
            $log = $this->connection->log();
            return $t;
        } else {
            $where['LIMIT'] = [($page - 1) * $limit, $limit];
            return $this->connection->select('tasks', ['[>]users' => ['user_id' => 'id']], '*', $where);
        }
    }

    //need get or update
    public function setTasks(array $data, $id = null)
    {
        if ($id)
            $this->connection->update(
                'tasks',
                [
                    'body' => $data['body'],
                    'state' => $data['state']
                ],
                ['id' => $id]
            );
        else
            $this->connection->insert('tasks', $data);

        if ($this->connection->error()[2]) {
//            $logger->error('setTasks:failed', ['err'=>$this->connection->error()]);
            return false;
        } else {
            return true;
        }
    }

    public function deleteTasks(array $where)
    {
        $this->connection->delete('tasks', $where);
    }

    public function checkPerm($username)
    {
        return $this->connection->get('users', 'admin', ['username' => $username]);
//        if ($is_admin)
//            return true;
//        else
//            return false;
    }

    public function countTasks()
    {
        return $this->connection->count('tasks');
    }
}




