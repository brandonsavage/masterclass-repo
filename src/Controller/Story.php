<?php

namespace Masterclass\Controller;

use Aura\Payload_Interface\PayloadStatus;
use Aura\Session\Session;
use Aura\View\View;
use Masterclass\Model\Comment as CommentModel;
use Masterclass\Model\Stories\StoryReadService;
use Masterclass\Model\Stories\StoryWriteService;
use Masterclass\Model\Story as StoryModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;
use Zend\Diactoros\ServerRequest;

class Story {

    public function __construct(
        StoryReadService $storyModel,
        StoryWriteService $storyWriteService,
        CommentModel $commentModel,
        ServerRequest $request,
        Session $session,
        View $view
    ) {
        $this->request = $request;
        $this->storyModel = $storyModel;
        $this->commentModel = $commentModel;
        $this->session = $session;
        $this->view = $view;
        $this->storyWriteService = $storyWriteService;
    }
    
    public function index() {
        $params = $this->request->getQueryParams();
        if(!isset($params['id'])) {
            header("Location: /");
            exit;
        }


        $storyModel = $this->storyModel;
        $story = $storyModel->getStory($params['id']);

        if(!$story) {
            header("Location: /");
            exit;
        }

        /** @var CommentModel $commentModel */
        $commentModel = $this->commentModel;

        $commentArr = $commentModel->findCommentsForStory($story->id);
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

        $post = $this->request->getParsedBody();

        $error = '';
        if(isset($post['create'])) {
            $storyModel = $this->storyWriteService;

            $segment = $this->session->getSegment('Masterclass');

            $payload = $storyModel->createNewStory(
                $post['headline'],
                $post['url'],
                $segment->get('username')
            );

            if ($payload->getStatus() == PayloadStatus::CREATED) {
                $story = $payload->getOutput();

                header("Location: /story?id=$story->id");
                exit;
            }
        }

        $reason = $payload->getStatus();
        $messages = $payload->getOutput();

        if ($reason == PayloadStatus::NOT_VALID) {
            // Yes, we are intentionally nesting foreach loops. This will always be
            // a small dataset.
            foreach ($messages as $message) {
                foreach ($message as $messageSpecific) {
                    $error .= $messageSpecific . '<br />';
                }
            }
        } else if ($reason == PayloadStatus::ERROR) {
            $error = $messages->getMessage();
        }

        $this->view->setData(['errors' => $error]);
        $this->view->setLayout('layout');
        $this->view->setView('storyCreate');
        return $this->view->__invoke();
    }
    
}