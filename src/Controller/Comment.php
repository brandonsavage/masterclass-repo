<?php

namespace Masterclass\Controller;

use Masterclass\Model\CommentMysqlDataStore as CommentModel;
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
            header("Location: /");
            exit;
        }

        $this->commentModel->addComment(
            $_SESSION['username'],
            $this->request->getPostParam('story_id'),
            $this->request->getSanitizedValue($this->request->getPostParam('comment'))
        );

        header("Location: /story/?id=" . $_POST['story_id']);
    }
}
