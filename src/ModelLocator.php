<?php

namespace Masterclass;

abstract class ModelLocator
{
    protected static $pdo;

    static public function setPdo(\PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    static public function loadModel($modelName)
    {
        return new $modelName(self::$pdo);
    }
}