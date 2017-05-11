<?php

namespace Masterclass\Domain;


interface Value
{

    /**
     * String representation of value.
     *
     * @return string
     */
    public function __toString();

    /**
     * Compares value with another object and returns bool.
     *
     * @param Value $value
     *
     * @return bool
     */
    public function equals(Value $value);
}
