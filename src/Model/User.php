<?php

namespace Masterclass\Model;

use PDO;

class User
{
    /**
     * @var PDO
     */
    protected $db;
    public function __construct($config) {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $username
     * @return mixed
     */
    public function checkUsername($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->db->prepare($check_sql);
        $check_stmt->execute(array($username));
        return $check_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return string
     */
    public function createUser($username, $email, $password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $username,
            $email,
            md5($username . $password)
        ));

        return $this->db->lastInsertId();
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function updatePassword($username, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            md5($username . $password), // THIS IS NOT SECURE.
            $username,
        ));
        return true;
    }

    public function getUserInfo($username)
    {
        $dsql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->db->prepare($dsql);
        $stmt->execute(array($username));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateUser($username, $password)
    {
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $password));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}