<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 17:32
 */

namespace Masterclass\Command\Commands;


class CreateUser
{
    public $username;
    public $password;
    public $passwordCompare;
    public $email;

    public function __construct($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
}