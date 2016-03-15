<?php
/**
 * @author Adam Altman <adam@rebilly.com>
 * masterclass-repo
 */

namespace Masterclass\Model;

use Masterclass\Db\Interfaces\DataStore;

final class Story
{
    protected $dataStore;

    public function __construct(DataStore $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->dataStore->fetchAll($sql);

        foreach ($stories as $k => $story) {
            $comment_sql = 'SELECT count(*) as `count` FROM comment WHERE story_id = ?';
            $count = $this->dataStore->fetchOne($comment_sql, [$story['id']]);
            $stories[$k]['count'] = $count['count'];
        }

        return $stories;
    }

    public function loadStoryById($storyId)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';

        return $this->dataStore->fetchOne($story_sql, [$storyId]);
    }

    public function createStory($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $this->dataStore->insert(
            $sql,
            [
                $headline,
                $url,
                $username,
            ]
        );

        return $this->dataStore->lastInsertId();
    }
}
