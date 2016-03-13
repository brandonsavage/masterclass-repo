<?php
/**
 * @author Adam Altman <adam@rebilly.com>
 * masterclass-repo
 */

namespace Masterclass\Model;

use PDO;

final class Story
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stories as $k => $story) {
            $comment_sql = 'SELECT count(*) as `count` FROM comment WHERE story_id = ?';
            $comment_stmt = $this->pdo->prepare(($comment_sql));
            $comment_stmt->execute([$story['id']]);
            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $stories[$k]['count'] = $count['count'];
        }

        return $stories;
    }

    public function loadStoryById($storyId)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->pdo->prepare($story_sql);
        $story_stmt->execute([$storyId]);

        return $story_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createStory($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $headline,
            $url,
            $username,
        ]);

        return $this->pdo->lastInsertId();
    }
}


// composer require aura/di
