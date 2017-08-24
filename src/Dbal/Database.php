<?php

namespace Masterclass\Dbal;

use PDO;

class Database implements DbalInterface
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetch($sql, array $args = [])
    {
        $stmt = $this->prepare($sql, $args);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, array $args = [])
    {
        $stmt = $this->prepare($sql, $args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($sql, array $args = [])
    {
        $stmt = $this->prepare($sql, $args);
        return $this->pdo->lastInsertId();
    }

    protected function prepare($sql, array $args = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}