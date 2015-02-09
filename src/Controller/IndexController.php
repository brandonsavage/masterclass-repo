<?php

namespace Jsposato\Controller;

use Jsposato\Model\Story as StoryModel;

class IndexController {

    /**
     * @var Story
     */
    protected $story;

    public function __construct(StoryModel $story) {
        $this->story = $story;
    }
    
    public function index() {
        
        $stories = $this->story->getStories();

        $content = '<ol>';
        
        foreach($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

