<?php

namespace Masterclass\Model;

use PDO;

class Story
{
    /**
     * @var PDO
     */
    protected $db;
    public function __construct($config) {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return array
     */
    public function getStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($stories as $key => $story){
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $comment_stmt = $this->db->prepare($comment_sql);
            $comment_stmt->execute(array($story['id']));
            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $stories[$key]['count'] = $count['count'];
        }
        return $stories;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStory($id)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->db->prepare($story_sql);
        $story_stmt->execute(array($id));
        return $story_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createNewStory($headline, $url, $creator)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $headline,
            $url,
            $creator
        ));

        return $this->db->lastInsertId();
    }

}