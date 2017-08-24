<?php

namespace Masterclass\Controller;

use Aura\Session\Session;
use Masterclass\Model\Comment as CommentModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;

class Comment {

    public function __construct(Request $request, CommentModel $commentModel, Session $session) {
        $this->request = $request;
        $this->commentModel = $commentModel;
        $this->session = $session;
    }
    
    public function create() {
        $segment = $this->session->getSegment('Masterclass');
        if(!$segment->get('AUTHENTICATED')) {
            header("Location: /");
            exit;
        }

        /** @var CommentModel $commentModel */
        $commentModel = $this->commentModel;

        $commentModel->postComment(
            $this->request->getPost('story_id'),
            $segment->get('username'),
            filter_var($this->request->getPost('comment'), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        header("Location: /story?id=" . $this->request->getPost('story_id'));
    }
    
}