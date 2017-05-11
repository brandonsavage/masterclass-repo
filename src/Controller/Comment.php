<?php
namespace Masterclass\Controller;

use Masterclass\Model\Comment as Model_Comment;
use Aura\Web\Request as Web_Request;
use Aura\Web\Response as Web_Response;

class Comment
{

    /**
     * @var Model_Comment
     */
    protected $comment_model;

    /**
     * @var Web_Request
     */
    protected $request;

    /**
     * @var Web_Response
     */
    protected $response;

    public function __construct(
        Model_Comment $comment_model,
        Web_Request $request,
        Web_Response $response
    )
    {
        $this->comment_model = $comment_model;
        $this->request = $request;
        $this->response = $response;
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            $this->response->redirect->to('/');
            return $this->response;
        }

        $story_id = (int)$this->request->post->get('story_id');
        $comment = $this->request->post->get('comment');
        $this->comment_model->postNewComment(
            $_SESSION['username'],
            $story_id,
            $comment
        );
        $this->response->redirect->to("/story?id={$story_id}");
        return $this->response;
    }

}
