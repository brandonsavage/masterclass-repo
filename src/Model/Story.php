<?php

namespace Jsposato\Model;

use Jsposato\Dbal\AbstractDb;

class Story
{
    /**
     * @var AbstractDb
     */
    protected $db;

    /**
     * @param AbstractDb $db
     */
    public function __construct( AbstractDb $db ) {
        $this->db = $db;

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

        $stories = $this->db->fetchAll($sql);

        foreach($stories as $key => $story) {
            $comment_sql  = 'SELECT COUNT(*) as count FROM comment WHERE story_id = ?';
            $count = $this->db->fetchOne($comment_sql, [$story['id']]);
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

        return $this->db->fetchOne($story_sql, [$story_id]);
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

        $this->db->execute($sql);

        return $this->db->lastInsertId();
    }
}