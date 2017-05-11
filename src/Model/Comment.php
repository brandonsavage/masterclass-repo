<?php
namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

final class Comment
{
    /**
     * @var AbstractDb $db
     */
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    public function getCommentsForStory($story_id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        return $this->db->fetchAll($sql, [$story_id]);
    }

    public function postNewComment($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        if ($this->db->execute($sql, [
            $username,
            $story_id,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ])
        ) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
