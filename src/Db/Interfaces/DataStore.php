<?php

namespace Masterclass\Db\Interfaces;

interface DataStore
{
    public function fetchOne($sql, array $args = []);
    public function fetchAll($sql, array $args = []);
    public function rowCount($sql, array $args = []);
    public function save($sql, array $args = []);
    public function lastInsertId();
}
