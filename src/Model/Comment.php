<?php
namespace Masterclass\Model;

use PDO;

final class Comment
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getCommentsForStory($story_id)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute([$story_id]);
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    public function postNewComment($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
            $username,
            $story_id,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ])
        ) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
