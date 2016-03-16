<?php

namespace Masterclass\Db;

use Masterclass\Db\DataStore;
use PDO;

class Mysql implements DataStore
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $sql
     * @param array $args
     *
     * @return mixed
     */
    public function fetchOne($sql, array $args = [])
    {
        $statement = $this->pdo->prepare($sql, $args);
        $statement->execute($args);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, array $args = [])
    {
        $statement = $this->pdo->prepare($sql, $args);
        $statement->execute($args);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param array $args
     *
     * @return int
     */
    public function rowCount($sql, array $args = [])
    {
        $statement = $this->pdo->prepare($sql, $args);
        $statement->execute($args);

        return $statement->rowCount();
    }

    public function insert($sql, array $args = [])
    {
        $statement = $this->pdo->prepare($sql, $args);

        return $statement->execute($args);
    }

    public function update($sql, array $args = [])
    {
        $statement = $this->pdo->prepare($sql, $args);

        return $statement->execute($args);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
