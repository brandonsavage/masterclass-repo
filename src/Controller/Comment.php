<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;
use Masterclass\Request;

class Comment
{
    protected $commentModel;
    protected $request;

    public function __construct(CommentModel $comment, Request $request)
    {
        $this->commentModel = $comment;
        $this->request = $request;
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            // @todo: die, redirect, exit... what is desired functionality?
            die('not auth');
            header("Location: /");
            exit;
        }

        $this->commentModel->addComment(
            $_SESSION['username'],
            $this->request->getPostParam('story_id'),
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        header("Location: /story/?id=" . $_POST['story_id']);
    }
}
