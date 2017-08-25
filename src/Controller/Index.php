<?php

namespace Masterclass\Controller;

use Aura\View\View;
use Masterclass\Model\Stories\StoryReadService;
use Masterclass\Model\Story as StoryModel;

class Index {

    /**
     * @var StoryReadService
     */
    private $storyModel;

    /**
     * @var View
     */
    private $view;

    public function __construct(StoryReadService $storyModel, View $view)
    {
        $this->storyModel = $storyModel;
        $this->view = $view;
    }

    public function index() {

        $storyModel = $this->storyModel;
        $stories = $storyModel->getStories();

        $this->view->setData(['stories' => $stories]);
        $this->view->setLayout('layout');
        $this->view->setView('index');
        return $this->view->__invoke();
    }
}

