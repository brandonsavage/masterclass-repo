<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/25/17
 * Time: 12:12
 */

namespace Masterclass\Model\Users;


use Masterclass\Dbal\DbalInterface;
use Masterclass\Model\Users\Exceptions\UserAlreadyExists;

class UserStorage
{
    /**
     * @var DbalInterface
     */
    protected $dbal;

    public function __construct(DbalInterface $dbal)
    {
        $this->dbal = $dbal;
    }

    public function findUserDataByUsername($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $data = $this->dbal->fetch($sql, [$username]);
        return $data;
    }

    public function createUser($username, $password, $email)
    {
        $user = $this->findUserDataByUsername($username);
        if ($user) {
            throw new UserAlreadyExists('User ' . $username . ' already exists');
        }

        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $this->dbal->save($sql, [$username, $email, $password]);

        return $this->findUserDataByUsername($username);
    }

    public function updateUserPassword($username, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        return $this->dbal->save($sql, [$password, $username]);
    }
}