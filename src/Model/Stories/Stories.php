<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 15:01
 */

namespace Masterclass\Model\Stories;


class Stories implements \Iterator, \Countable
{
    protected $collection = array();

    public function addEntity(Story $entity)
    {
        $this->collection[] = $entity;
        return $this;
    }

    public function addEntities(array $entities = array())
    {
        foreach ($entities as $entity) {
            $this->addEntity($entity);
        }
        return $this;
    }

    public function count()
    {
        return count($this->collection);
    }

    public function current()
    {
        return current($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function next()
    {
        return next($this->collection);
    }

    public function rewind()
    {
        reset($this->collection);
    }

    public function valid()
    {
        return (bool)$this->current();
    }
}