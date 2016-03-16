<?php

namespace Masterclass\Domain;


abstract class ValueObject implements Value
{
    public function __toString()
    {
        return var_export($this, true);
    }

    /**
     * Value objects are immutable.  They are equal if their attributes are the same.
     * Implement this method according to the specifics of the value object.
     *
     * @param Value $value
     *
     * @return bool
     */
    abstract public function equals(Value $value);
}
