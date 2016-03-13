<?php

namespace Masterclass\Model;

use PDO;

final class Comment
{
    protected $pdo;
    protected $errors = [];
    protected $storyId;
    protected $comment;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addComment($username, $storyId, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $username,
            $storyId,
            $comment,
        ]);
    }

    public function getCommentsForStoryId($storyId)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->pdo->prepare($comment_sql);
        $comment_stmt->execute([$storyId]);
        $comment_count = $comment_stmt->rowCount();
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }
}
