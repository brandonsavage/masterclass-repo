<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/25/17
 * Time: 12:12
 */

namespace Masterclass\Model\Users;


use Masterclass\Model\Users\Exceptions\PasswordAndCheckDoNotMatch;
use Masterclass\Model\Users\Exceptions\UserNotFound;

class UserGateway
{
    protected $storage;

    public function __construct(UserStorage $storage)
    {
        $this->storage = $storage;
    }

    public function findUserByUsername($username)
    {
        $userData = $this->storage->findUserDataByUsername($username);

        if (!$userData) {
            throw new UserNotFound('User ' . $username . ' was not found');
        }

        return new User($userData);
    }

    public function checkUserAuthentication($username, $password)
    {
        $user = $this->findUserByUsername($username);
        $user->checkPassword(md5($username . $password)); // throws an exception if failed
        return $user;
    }

    public function createUser($username, $password, $email)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->email = $email;

        if ($user->validate()) {
            $data = $this->storage->createUser($user->username, $user->getPassword(), $user->email);
            return new User($data);
        }
    }

    public function changePassword($username, $password)
    {
        $user = $this->findUserByUsername($username);

        $user->setPassword($password);

        $this->storage->updateUserPassword($user->username, $user->getPassword());
    }
}