<?php

namespace Masterclass\Dbal;

interface DbalInterface
{
    public function fetch($sql, array $args = []);

    public function fetchAll($sql, array $args = []);

    public function save($sql, array $args = []);
}