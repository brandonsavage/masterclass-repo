<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;

class Comment {

    public function __construct(Request $request, PDO $pdo) {
        $this->request = $request;
        $this->db = $pdo;
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        /** @var CommentModel $commentModel */
        $commentModel = ModelLocator::loadModel(CommentModel::class);

        $commentModel->postComment(
            $this->request->getPost('story_id'),
            $_SESSION['username'],
            filter_var($this->request->getPost('comment'), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        header("Location: /story?id=" . $this->request->getPost('story_id'));
    }
    
}