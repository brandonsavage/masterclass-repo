<?php

namespace Masterclass\Domain\User;


use Masterclass\Domain\Value;
use Masterclass\Domain\ValueObject;

class UserId extends ValueObject implements Value
{
    protected $id;

    /**
     * UserId constructor.
     *
     * @param int $id (It seems it must be an int, as it's a mysql autoincrement int.)
     */
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
