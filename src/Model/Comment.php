<?php

namespace Masterclass\Model;

use PDO;

class Comment
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
     * @param $id
     * @return array
     */
    public function getCommentsForStory($id){
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute(array($id));
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    /**
     * @param $username
     * @param $story_id
     * @param $comment
     * @return bool
     */
    public function postNewComment($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array(
            $username,
            $story_id,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ));
    }

}