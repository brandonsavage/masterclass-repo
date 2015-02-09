<?php

namespace Jsposato\Model;

use PDO;

class Story
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * @param PDO $pdo
     */
    public function __construct( PDO $pdo ) {
        $this->db = $pdo;

    }

    /**
     * getStories
     *
     * get all stories from table
     *
     * @return array
     *
     * @author  jsposato
     * @version 1.0
     */
    public function getStories() {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($stories as $key => $story) {
            $comment_sql  = 'SELECT COUNT(*) as count FROM comment WHERE story_id = ?';
            $comment_stmt = $this->db->prepare( $comment_sql );
            $comment_stmt->execute( array( $story['id'] ) );
            $count = $comment_stmt->fetch( PDO::FETCH_ASSOC );
            $stories[$key]['count'] = $count['count'];
        }

        return $stories;
    }

    /**
     * getOneStory
     *
     * get one story from table, identified by id
     *
     * @param $story_id
     *
     * @return mixed
     *
     * @author  jsposato
     * @version 1.0
     */
    public function getOneStory($story_id) {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->db->prepare($story_sql);
        $story_stmt->execute(array($story_id));
        $story = $story_stmt->fetch(PDO::FETCH_ASSOC);

        return $story;
    }

    /**
     * createStory
     *
     * add a story to the table
     *
     * @param $headline
     * @param $url
     * @param $created_by
     *
     * @return string
     *
     * @author  jsposato
     * @version 1.0
     */
    public function createStory($headline, $url, $created_by) {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
                           $headline,
                           $url,
                           $created_by,
                       ]);

        $id = $this->db->lastInsertId();

        return $id;
    }
}