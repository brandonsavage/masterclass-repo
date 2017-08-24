<?php

namespace Masterclass\Model;

use PDO;

class Story
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

    public function loadStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stories as $key => $story)
        {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $comment_stmt = $this->pdo->prepare($comment_sql);
            $comment_stmt->execute(array($story['id']));
            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $stories[$key]['count'] = $count['count'];
        }

        return $stories;
    }

    public function fetchStory($storyId)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->pdo->prepare($story_sql);
        $story_stmt->execute(array($storyId));
        return $story_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createStory($headline, $url, $created_by)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            $headline,
            $url,
            $created_by,
        ));

        return $this->pdo->lastInsertId();
    }
}