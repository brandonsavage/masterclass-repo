<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 15:59
 */

namespace Masterclass\Dbal\Decorators;


use Masterclass\Dbal\DbalInterface;

class Apc implements DbalInterface
{
    /**
     * @var DbalInterface
     */
    protected $dbal;

    public function __construct(DbalInterface $dbal)
    {
        $this->dbal = $dbal;
    }

    public function fetch($sql, array $args = [])
    {
        if ($result = $this->lookupQuery($sql, $args)) {
            return $result;
        }

        $result = $this->dbal->fetch($sql, $args);

        $this->saveQuery($sql, $args, $result);

        return $result;
    }

    public function fetchAll($sql, array $args = [])
    {
        if ($result = $this->lookupQuery($sql, $args)) {
            return $result;
        }

        $result = $this->dbal->fetchAll($sql, $args);

        $this->saveQuery($sql, $args, $result);

        return $result;
    }

    public function save($sql, array $args = [])
    {
        return $this->dbal->save($sql, $args);
    }

    protected function lookupQuery($sql, array $args = [])
    {

        return unserialize(apc_fetch($this->encodeQueryString($sql, $args)));
    }

    protected function saveQuery($sql, array $args = [], $result)
    {
        return apc_store($this->encodeQueryString($sql, $args), serialize($result));
    }

    private function encodeQueryString($sql, array $args = [])
    {
        return $sql . serialize($args);
    }
}