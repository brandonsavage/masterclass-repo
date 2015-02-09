<?php

namespace Jsposato\Dbal;

use Jsposato\Dbal\AbstractDb;

class Mysql extends AbstractDb
{

    /**
     * fetchOne
     *
     * fetch one row
     *
     * @param       $sql
     * @param array $bind
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    public function fetchOne($sql, array $bind = []) {

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetch();
    }

    /**
     * fetchAll
     *
     * fetch all rows
     *
     * @param       $sql
     * @param array $bind
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    public function fetchAll($sql, array $bind = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetch();
    }

    /**
     * execute
     *
     * execute sql query
     *
     * @param       $sql
     * @param array $bind
     *
     * @return bool
     *
     * @author  jsposato
     * @version 1.0
     */
    public function execute($sql, array $bind = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($bind);
    }
}