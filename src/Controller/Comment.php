<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;

class Comment
{
    protected $commentModel;

    public function __construct(CommentModel $comment)
    {
        $this->commentModel = $comment;
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $this->commentModel->addComment(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        header("Location: /story/?id=" . $_POST['story_id']);
    }
}
