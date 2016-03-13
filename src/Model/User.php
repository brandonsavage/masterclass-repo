<?php

namespace Masterclass\Model;

use Masterclass\Db\Interfaces\DataStore;


final class User
{
    protected $dataStore;
    protected $errors = [];
    protected $username;
    protected $email;
    protected $hashedPassword;

    public function __construct(DataStore $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    /**
     * @param $username
     *
     * @return bool
     */
    public function userExists($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        return (bool) $this->dataStore->rowCount($check_sql, [$username]);
//            $error = 'Your chosen username already exists. Please choose another.';
    }

    /**
     * @param $username
     *
     * @return self
     *
     * @throws
     */
    public function loadUserByUsername($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';

        // @todo: double query, here and line ~48.
        if (!$this->userExists($username)) {
            throw new \Exception('User not found');
        }

        $row = $this->dataStore->fetchOne($check_sql, [$username]);

        $this->username = $username;
        $this->email = $row['email'];
        $this->hashedPassword = $row['password'];

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function checkCredentials($username, $password)
    {
//        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
//        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';

        $this->loadUserByUsername($username);

        return password_verify($password, $this->hashedPassword);
    }

    public function createUser($username, $email, $password)
    {
        $this->setPassword($password);
        $params = [
            $username,
            $email,
            $this->hashedPassword,
        ];
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $this->dataStore->save($sql, $params);
    }

    public function updatePassword($username, $password)
    {
        $this->setPassword($password);
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $this->dataStore->save($sql, [$this->hashedPassword, $username]);
    }

    protected function setPassword($password)
    {
        if (empty($password)) {
            throw new \Exception('Password is required');
        }
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }
}
