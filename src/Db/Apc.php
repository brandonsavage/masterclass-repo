<?php

namespace Masterclass\Db;

use Masterclass\Db\Interfaces\DataStore;

class Apc implements DataStore
{
    protected $db;
    protected $ttl;

    public function __construct(Mysql $mysql, int $ttl = 60)
    {
        $this->db = $mysql;
        $this->ttl = $ttl;
    }

    public function fetchOne($sql, array $args = [])
    {
        $key = md5($sql . serialize($args));
        $value = apc_fetch($key);

        if (!$value) {
            $value = $this->db->fetchOne($sql, $args);
            apc_store($key, $value, $this->ttl);
        }

        return $value;
    }

    public function fetchAll($sql, array $args = [])
    {
        $key = md5($sql . serialize($args));
        $value = apc_fetch($key);

        if (!$value) {
            $value = $this->db->fetchAll($sql, $args);
            apc_store($key, $value, $this->ttl);
        }

        return $value;
    }

    public function rowCount($sql, array $args = [])
    {
        $key = md5('rowCount' . $sql . serialize($args));
        $value = apc_fetch($key);

        if (!$value) {
            $value = $this->db->rowCount($sql, $args);
            apc_store($key, $value, $this->ttl);
        }

        return $value;
    }

    public function insert($sql, array $args = [])
    {
        return $this->db->insert($sql, $args);
        // no cache to invalidate
    }

    /**
     * @TODO - this should invalidate the corresponding select cache
     * set default to 60 second ttl to compensate.
     *
     * @param $sql
     * @param array $args
     *
     * @return bool
     */
    public function update($sql, array $args = [])
    {
        return $this->db->update($sql, $args);
        // @todo
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
