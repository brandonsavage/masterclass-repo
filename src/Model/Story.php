<?php

namespace Masterclass\Model;

use Masterclass\Dbal\DbalInterface;
use PDO;

class Story
{
    /**
     * @var DbalInterface
     */
    protected $pdo;

    /**
     * Story constructor.
     * @param DbalInterface $pdo
     */
    public function __construct(DbalInterface $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->pdo->fetchAll($sql);

        foreach ($stories as $key => $story)
        {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $count = $this->pdo->fetch($comment_sql, [$story['id']]);
            $stories[$key]['count'] = $count['count'];
        }

        return $stories;
    }

    public function fetchStory($storyId)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        return $this->pdo->fetch($story_sql, [$storyId]);
    }

    public function createStory($headline, $url, $created_by)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $id = $this->pdo->save($sql, [$headline, $url, $created_by]);
        return $id;
    }
}