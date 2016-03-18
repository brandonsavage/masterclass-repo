<?php
namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

final class Story
{
    /**
     * @var AbstractDb $db
     */
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    public function getStory($story_id)
    {
        $sql = 'SELECT * FROM story WHERE id = ?';
        return $this->db->fetchOne($sql, [$story_id]);
    }

    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->db->fetchAll($sql, []);

        foreach ($stories as $k => $story) {
            $count = $this->db->fetchOne('SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?', [$story['id']]);
            $stories[$k]['count'] = $count['count'];
        }
        return $stories;
    }

    public function postStory($username, $headline, $url)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        if ($this->db->execute($sql, [
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
