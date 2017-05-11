<?php

namespace Masterclass\Domain\Story;


use Masterclass\Domain\Value;
use Masterclass\Domain\ValueObject;

class StoryId extends ValueObject implements Value
{
    protected $id;

    public function __construct(int $id)
    {
        $this->setId($id);
    }

    public function getId()
    {
        return $this->id;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function equals(Value $value)
    {
        return $value instanceof self && (string) $value === (string) $this->id;
    }
}
