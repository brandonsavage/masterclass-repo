<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 15:01
 */

namespace Masterclass\Model\Stories;

use Masterclass\Dbal\Database;
use Masterclass\Dbal\DbalInterface;
use PDO;

class StoryStorage
{
    /**
     * @var DbalInterface
     */
    protected $database;

    public function __construct(DbalInterface $database)
    {
        $this->database = $database;
    }

    public function getRawStoryData()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->database->fetchAll($sql);

        foreach ($stories as $key => $story)
        {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $count = $this->database->fetch($comment_sql, [$story['id']]);
            $stories[$key]['comment_count'] = $count['count'];
        }

        return $stories;
    }

    public function getSingleStoryData($storyId)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        return $this->database->fetch($story_sql, [$storyId]);
    }

    public function createStory($headline, $url, $created_by)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $id = $this->database->save($sql, [$headline, $url, $created_by]);
        return $this->getSingleStoryData($id);
    }
}