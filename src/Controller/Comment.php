<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;

class Comment {

  /**
   * @var CommentModel
   */
  protected $commentModel;
    
  public function __construct($config) {
    $this->commentModel = new CommentModel($config);
  }

  public function create() {
    if(!isset($_SESSION['AUTHENTICATED'])) {
      header("Location: /");
      exit;
    }

    $this->commentModel->postNewComment($_SESSION['username'], $_POST['story_id'], $_POST['comment']);

    header("Location: /story/?id=" . $_POST['story_id']);
  }
    
}