<?php

namespace Masterclass\Model;

use Masterclass\Db\DataStore;
use Masterclass\Domain\Story\CommentDataStore;

final class CommentMysqlDataStore implements CommentDataStore
{
    protected $storyId;
    protected $dataStore;

    public function __construct(DataStore $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    public function addComment($username, $storyId, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $this->dataStore->insert(
            $sql,
            [
                $username,
                $storyId,
                $comment,
            ]
        );
    }

    public function getCommentsForStoryId($storyId)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->dataStore->fetchAll($sql, [$storyId]);
    }
}
