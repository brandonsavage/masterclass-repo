<?php
namespace Masterclass\Controller;

use Masterclass\Model\Story as Model_Story;
use Aura\View\View as Aura_View;
use Aura\Web\Response as Web_Response;

class Index
{
    /**
     * @var Model_Story
     */
    protected $story_model;

    /** @var  Web_Response */
    protected $response;

    /** @var  Aura_View */
    protected $view;

    public function __construct(
        Model_Story $story_model,
        Web_Response $response,
        Aura_View $view
    )
    {
        $this->story_model = $story_model;
        $this->response = $response;
        $this->view = $view;
    }

    public function index()
    {
        $stories = $this->story_model->getAllStories();
        $this->view->setLayout('layout');
        $this->view->setView('index');

        $this->view->setData(['stories' => $stories]);
        $this->response->content->set($this->view->__invoke());
        return $this->response;
    }
}

