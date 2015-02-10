<?php

namespace Jsposato\Controller;

use Jsposato\Model\Story as StoryModel;
use Jsposato\Model\Comment as CommentModel;

class StoryController {

    /**
     * @var StoryModel
     */
    protected $storyModel;

    /**
     * @var CommentModel
     */
    protected $commentModel;

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var
     */
    private $arrStory;

    /**
     * @var
     */
    private $comments;

    public function __construct(StoryModel $story, CommentModel $comment) {
        $this->storyModel = $story;
        $this->commentModel = $comment;
    }
    
    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }

        $this->arrStory = $this->storyModel->getOneStory($_GET['id']);
        if(count($this->arrStory) < 1) {
            header("Location: /");
            exit;
        }

        $this->comments = $this->commentModel->getComments($_GET['id']);

        $content = '
            <a class="headline" href="' . $this->arrStory['url'] . '">' . $this->arrStory['headline'] . '</a><br />
            <span class="details">' . $this->arrStory['created_by'] . ' | ' . $this->comments['count'] . ' Comments |
            ' . date('n/j/Y g:i a', strtotime($this->arrStory['created_on'])) . '</span>
        ';
        
        if(isset($_SESSION['AUTHENTICATED'])) {
            $content .= '
            <form method="post" action="/comment/create/save">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
        }
        
        foreach($this->comments as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($this->arrStory['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
        }
        
        require_once '../layout.phtml';
        
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        $error = '';
        if(isset($_POST['create'])) {
            if(!isset($_POST['headline']) || !isset($_POST['url']) ||
               !filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) {
                $error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                $id = $this->storyModel->createStory($_POST['headline'], $_POST['url'], $_SESSION['username']);
                header("Location: /story?id=$id");
                exit;
            }
        }
        
        $content = '
            <form method="post">
                ' . $error . '<br />
        
                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';
        
        require_once '../layout.phtml';
    }
    
}