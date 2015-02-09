<?php

namespace Jsposato\Dbal;

use PDO;

abstract class AbstractDb
{

    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct($dsn, $user, $pass) {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    /**
     * fetchOne
     *
     * fetch one row for an entity
     *
     * @param       $sql
     * @param array $bind
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    abstract public function fetchOne($sql, array $bind = []);

    /**
     * fetchAll
     *
     * fetch all rows for an entity
     *
     * @param       $sql
     * @param array $bind
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    abstract public function fetchAll($sql, array $bind = []);

    /**
     * execute
     *
     * execute query
     *
     * @param       $sql
     * @param array $bind
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    abstract public function execute($sql, array $bind = []);

    /**
     * lastInsertId
     *
     * return id of last row inserted
     *
     * @return string
     *
     * @author  jsposato
     * @version 1.0
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

}