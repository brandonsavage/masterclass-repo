<?php

namespace Masterclass\Db\Interfaces;

interface DataStore
{
    public function fetchOne($sql, array $args = []);
    public function fetchAll($sql, array $args = []);
    public function rowCount($sql, array $args = []);
    public function insert($sql, array $args = []);
    public function update($sql, array $args = []);
    public function lastInsertId();
}
