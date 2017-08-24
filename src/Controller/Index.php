<?php

namespace Masterclass\Controller;

use Aura\View\View;
use Masterclass\Model\Story as StoryModel;

class Index {

    /**
     * @var StoryModel
     */
    private $storyModel;

    /**
     * @var View
     */
    private $view;

    public function __construct(StoryModel $storyModel, View $view)
    {
        $this->storyModel = $storyModel;
        $this->view = $view;
    }

    public function index() {

        /** @var StoryModel $storyModel */
        $storyModel = $this->storyModel;
        $stories = $storyModel->loadStories();

        $this->view->setData(['stories' => $stories]);
        $this->view->setLayout('layout');
        $this->view->setView('index');
        return $this->view->__invoke();
    }
}

