<?php

namespace Masterclass\Dbal;

class Mysql extends AbstractDb
{
    public function fetchOne($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetch();
    }

    public function fetchAll($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll();
    }

    public function execute($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($bind);
    }
}
