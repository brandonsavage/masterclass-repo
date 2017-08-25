<?php

namespace Masterclass\Model\Users;

use Masterclass\Model\Users\Exceptions\EmailNotProvided;
use Masterclass\Model\Users\Exceptions\EmailNotValid;
use Masterclass\Model\Users\Exceptions\InvalidPasswordMatch;
use Masterclass\Model\Users\Exceptions\PasswordNotProvided;
use Masterclass\Model\Users\Exceptions\UsernameNotProvided;

class User
{
    public $id;
    public $username;
    public $email;

    protected $password;

    protected $excluded = ['excluded'];

    public function __construct(array $args = [])
    {
        foreach ($args as $key => $property) {
            if (property_exists($this, $key)) {
                $this->$key = $property;
            }
        }
    }

    public function toArray()
    {
        $data = [];

        foreach($this as $key => $value) {
            if (!in_array($key, $this->excluded)) {
                $data[$key] = $value;
            }
        }

        // To make saving easier.
        if (empty($data['id'])) {
            unset($data['id']);
        }

        return $data;
    }

    public function setPassword($password)
    {
        if (!$this->username) {
            throw new UsernameNotProvided('Username is required to set a password');
        }

        $this->password = md5($this->username . $password);
    }

    public function validate()
    {
        if (!$this->username) {
            throw new UsernameNotProvided('Username is required');
        }

        if(!$this->email) {
            throw new EmailNotProvided('Email is required!');
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailNotValid('Email address is not valid');
        }

        if(!$this->password) {
            throw new PasswordNotProvided('A password is required!');
        }

        return true;
    }

    public function checkPassword($hashedPassword)
    {
        if ($this->password != $hashedPassword) {
            throw new InvalidPasswordMatch('The passwords did not match');
        }

        return true;
    }

    public function getPassword()
    {
        return $this->password;
    }
}