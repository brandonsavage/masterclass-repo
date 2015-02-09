<?php

namespace Jsposato\Model;

use PDO;

class Comment
{

    /**
     * @param PDO $pdo
     */
    public function __construct( PDO $pdo ) {
        $this->db = $pdo;

    }

    /**
     * createComment
     *
     *
     *
     * @param $username
     * @param $story_id
     * @param $comment
     *
     * @author  jsposato
     * @version 1.0
     */
    public function createComment( $username, $story_id, $comment) {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
                           $username,
                           $story_id,
                           filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                       ));

    }

    /**
     * getComments
     *
     * get all comments for a story
     *
     * @param $story_id
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    public function getComments($story_id) {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute(array($story_id));
        $comment_count = $this->_getCommentCount($comment_stmt);
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        $comments['count'] = $comment_count;

        return $comments;
    }

    /**
     * _getCommentCount
     *
     *
     *
     * @param \PDOStatement $comment_stmt
     *
     * @return int
     *
     * @author  jsposato
     * @version 1.0
     */
    protected function _getCommentCount( \PDOStatement $comment_stmt) {
        return $comment_stmt->rowCount();
    }
}