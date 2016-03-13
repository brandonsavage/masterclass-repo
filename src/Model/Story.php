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

}


// composer require aura/di
