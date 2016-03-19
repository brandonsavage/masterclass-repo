<?php
namespace Masterclass\Controller;

use Masterclass\Model\Comment as Model_Comment;
use Masterclass\Model\Story as Model_Story;
use Aura\View\View as Aura_View;
use Aura\Web\Response as Web_Response;
use Aura\Web\Request as Web_Request;

class Story
{
    /**
     * @var Model_Comment
     */
    protected $comment_model;

    /**
     * @var Model_Story
     */
    protected $story_model;

    /**
     * @var Web_Response
     */
    protected $response;

    /**
     * @var Web_Request
     */
    protected $request;

    /**
     * @var Aura_View
     */
    protected $view;

    public function __construct(
        Model_Story $story_model,
        Model_Comment $comment_model,
        Web_Request $request,
        Web_Response $response,
        Aura_View $view
    )
    {
        $this->story_model = $story_model;
        $this->comment_model = $comment_model;
        $this->response = $response;
        $this->request = $request;
        $this->view = $view;
    }

    public function index()
    {
        $story_id = $this->request->query->get('id', 0);
        if (empty($story_id)) {
            $this->response->redirect->to('/');
            return $this->response;
        }

        $story = $this->story_model->getStory($story_id);
        if (empty($story)) {
            $this->response->redirect->to('/');
            return $this->response;
        }

        $comments = $this->comment_model->getCommentsForStory($story['id']);
        $story['comment_count'] = count($comments);

        $this->view->setData(['story' => $story, 'comments' => $comments]);
        $this->view->setLayout('layout');
        $this->view->setView('story');
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            $this->response->redirect->to('/user/login');
            return $this->response;
        }


        $error = '';
        if ($this->request->post->get('create')) {
            $headline = $this->request->post->get('headline');
            $url = $this->request->post->get('url');
            if (
                !$headline
                || !$url
                || !filter_var($url, FILTER_VALIDATE_URL)
            ) {
                $error = 'You did not fill in all the fields or the URL did not validate.';
            } else {
                $id = $this->story_model->postStory($_SESSION['username'], $headline, $url);
                $this->response->redirect->to("/story?id={$id}");
                return $this->response;
            }
        }

        $this->view->setView('story_create');
        $this->view->setLayout('layout');
        $this->view->setData(['error' => $error]);
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }

}
