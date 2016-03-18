<?php

namespace Masterclass\Model;

use PDO;


class Comment {

  /**
   * @var PDO
   */
  protected $db;

  /**
   * @param array $config
   */
  protected $config;

  public function __construct($config) {
    $this->config = $config;
    $dbconfig = $config['database'];
    $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
    $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
   * @param integer $storyId
   * @return array
   */
  public function getCommentsForStory($storyId) {
    $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
    $comment_stmt = $this->db->prepare($comment_sql);
    $comment_stmt->execute(array($storyId));
    $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
  }

  /**
   * @param string $username
   * @param integer $storyId
   * @param string $comment
   * @return bool
   */

  public function postNewComment($username, $storyId, $comment) {
    $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
    $stmt = $this->db->prepare($sql);
    $stmt->execute(array(
      $username,
      $storyId,
      filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
    ));
  }

}