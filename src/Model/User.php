<?php
namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

final class User
{
    /**
     * @var AbstractDb $db
     */
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    public function getUserByUserName($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        return $this->db->fetchOne($sql, [$username]);
    }

    public function postNewUser($username, $email, $password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        if ($this->db->execute($sql, [
            $username,
            $email,
            md5($username . $password),
        ])
        ) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updatePassword($username, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        return $this->db->execute($sql, [
            md5($username . $password), // THIS IS NOT SECURE.
            $username,
        ]);
    }
}
