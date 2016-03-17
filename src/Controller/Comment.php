<?php
namespace Masterclass\Controller;

use PDO;
use Masterclass\Model\Comment as Model_Comment;

class Comment
{

    /**
     * @var Model_Comment
     */
    protected $comment_model;

    public function __construct(PDO $db)
    {
        $this->comment_model = new Model_Comment($db);
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $this->comment_model->postNewComment($_SESSION['username'], $_POST['story_id'], $_POST['comment']);
        header("Location: /story/?id=" . $_POST['story_id']);
    }

}
