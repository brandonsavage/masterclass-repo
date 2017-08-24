<?php

namespace Masterclass\Model;

use PDO;

class Comment
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Story constructor.
     * @param \PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findCommentsForStory($storyId)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->pdo->prepare($comment_sql);
        $comment_stmt->execute(array($storyId));
        $comment_count = $comment_stmt->rowCount();
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['comments' => $comments, 'comment_count' => $comment_count];
    }

    public function postComment($storyId, $createdBy, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            $createdBy,
            $storyId,
            $comment,
        ));
    }
}