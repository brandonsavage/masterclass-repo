<?php

namespace Masterclass\Model;

use PDO;

final class User
{
    protected $pdo;
    protected $errors = [];
    protected $username;
    protected $email;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $username
     *
     * @return bool
     */
    public function userExists($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->pdo->prepare($check_sql);
        $check_stmt->execute([$username]);

        return (bool) $check_stmt->rowCount();
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
        $check_stmt = $this->pdo->prepare($check_sql);
        $check_stmt->execute([$username]);

        if ($check_stmt->rowCount() == 0) {
            throw new \Exception('User not found');
        }

        $row = $check_stmt->fetch(PDO::FETCH_ASSOC);

        $this->username = $username;
        $this->email = $row['email'];

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
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $password]);

        return (bool) $stmt->rowCount();
    }

    public function createUser($username, $email, $password)
    {
        $params = [
            $username,
            $email,
            md5($username . $password),
        ];
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function updatePassword($username, $password)
    {
        $password = md5($username . $password);
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$password, $username]);
    }
}
