<?php

namespace Masterclass\Controller;

use Aura\Session\Session;
use Aura\View\View;
use Masterclass\Model\Comment as CommentModel;
use Masterclass\Model\Story as StoryModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;

class Story {

    public function __construct(
        StoryModel $storyModel,
        CommentModel $commentModel,
        Request $request,
        Session $session,
        View $view
    ) {
        $this->request = $request;
        $this->storyModel = $storyModel;
        $this->commentModel = $commentModel;
        $this->session = $session;
        $this->view = $view;
    }
    
    public function index() {
        if(!$this->request->getQuery('id')) {
            header("Location: /");
            exit;
        }

        /** @var StoryModel $storyModel */
        $storyModel = $this->storyModel;
        $story = $storyModel->fetchStory($this->request->getQuery('id'));

        if(!$story) {
            header("Location: /");
            exit;
        }

        /** @var CommentModel $commentModel */
        $commentModel = $this->commentModel;

        $commentArr = $commentModel->findCommentsForStory($story['id']);
        $comments = $commentArr['comments'];
        $comment_count = $commentArr['comment_count'];

        $segment = $this->session->getSegment('Masterclass');

        $data = [
            'story' => $story,
            'comments' => $comments,
            'comment_count' => $comment_count,
            'authenticated' => $segment->get('AUTHENTICATED', false)
        ];

        $this->view->setData($data);
        $this->view->setLayout('layout');
        $this->view->setView('storyIndex');
        return $this->view->__invoke();
        
    }
    
    public function create() {
        $segment = $this->session->getSegment('Masterclass');
        if(!$segment->get('AUTHENTICATED')) {
            header("Location: /user/login");
            exit;
        }
        
        $error = '';
        if($this->request->getPost('create')) {
            if(!$this->request->getPost('headline') || !$this->request->getPost('url') ||
               !filter_var($this->request->getPost('url'), FILTER_VALIDATE_URL)) {
                $error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                /** @var StoryModel $storyModel */
                $storyModel = $this->storyModel;

                $id = $storyModel->createStory(
                    $this->request->getPost('headline'),
                    $this->request->getPost('url'),
                    $_SESSION['username']
                );

                header("Location: /story?id=$id");
                exit;
            }
        }

        $this->view->setData(['errors' => $error]);
        $this->view->setLayout('layout');
        $this->view->setView('storyCreate');
        return $this->view->__invoke();
    }
    
}