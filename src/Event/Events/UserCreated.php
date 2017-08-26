<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 18:17
 */

namespace Masterclass\Event\Events;


class UserCreated
{
    public $username;

    public function __construct($username)
    {
        $this->username = $username;
    }
}