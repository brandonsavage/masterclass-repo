<?php

namespace Jsposato\Controller;

use Jsposato\Model\Comment as CommentModel;

class CommentController {

    private $commentModel;
    protected $db;

    public function __construct(CommentModel $comment) {
        $this->commentModel = $comment;
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        /**
         * insert the comment
         */
        $this->commentModel->createComment($_SESSION['username'], $_POST['story_id'], $_POST['comment']);

        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}