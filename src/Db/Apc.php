<?php

namespace Masterclass\Db;

use Masterclass\Db\Interfaces\DataStore;

class Apc implements DataStore
{
    protected $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql;
    }

    public function fetchOne($sql, array $args = [])
    {
        $key = md5($sql . serialize($args));
        $value = apc_fetch($key);

        if (!$value) {
            $value = $this->db->fetchOne($sql, $args);
            apc_store($key, $value);
        }

        return $value;
    }
    public function fetchAll($sql, array $args = [])
    {

    }
    public function save($sql, array $args = [])
    {

    }

}
