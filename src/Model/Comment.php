<?php

namespace Jsposato\Model;

use Jsposato\Dbal\AbstractDb;

class Comment
{
    /**
     * @var AbstractDb
     */
    protected $db;

    /**
     * @param AbstractDb $db
     */
    public function __construct( AbstractDb $db ) {
        $this->db = $db;

    }

    /**
     * createComment
     *
     * add comment to story
     *
     * @param $username
     * @param $story_id
     * @param $comment
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    public function createComment( $username, $story_id, $comment) {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        return $this->db->execute($sql, array(
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
        $comments = $this->db->fetchAll($comment_sql, [$story_id]);
        $comments['count'] = count($comments);

        return $comments;
    }
}