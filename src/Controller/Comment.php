<?php

namespace Masterclass\Controller;

use Aura\Session\Session;
use Masterclass\Model\Comment as CommentModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;
use Zend\Diactoros\ServerRequest;

class Comment {

    public function __construct(ServerRequest $request, CommentModel $commentModel, Session $session) {
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

        $post = $this->request->getParsedBody();

        $commentModel->postComment(
            $post['story_id'],
            $segment->get('username'),
            filter_var($post['comment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        header("Location: /story?id=" . $post['story_id']);
    }
    
}