<?php

namespace Masterclass\Controller;

use Aura\Session\Session;
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
        Session $session
    ) {
        $this->request = $request;
        $this->storyModel = $storyModel;
        $this->commentModel = $commentModel;
        $this->session = $session;
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

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments | 
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';

        $segment = $this->session->getSegment('Masterclass');

        if($segment->get('AUTHENTICATED')) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $this->request->getQuery('id') . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
        }
        
        foreach($comments as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
        }
        
        require_once '../layout.phtml';
        
    }
    
    public function create() {
        $segment = $this->session->getSegment('Masterclass');
        if($segment->get('AUTHENTICATED')) {
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
        
        $content = '
            <form method="post" action="/story/create/save">
                ' . $error . '<br />
        
                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';
        
        require_once '../layout.phtml';
    }
    
}