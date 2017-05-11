<?php
namespace Masterclass\Model;

use PDO;

final class Story
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getStory($story_id)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->db->prepare($story_sql);
        $story_stmt->execute([$story_id]);
        return $story_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($stories as $k => $story) {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $comment_stmt = $this->db->prepare($comment_sql);
            $comment_stmt->execute([$story['id']]);
            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $stories[$k]['count'] = $count['count'];
        }
        return $stories;
    }

    public function postStory($username, $headline, $url)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
            $headline,
            $url,
            $username,
        ])
        ) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
