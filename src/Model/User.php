<?php
namespace Masterclass\Model;

use PDO;

final class User
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getUserByUserName($username)
    {
        $query = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function postNewUser($username, $email, $password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
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
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            md5($username . $password), // THIS IS NOT SECURE.
            $username,
        ]);
    }
}
