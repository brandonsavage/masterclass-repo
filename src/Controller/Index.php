<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as StoryModel;

class Index {

    /**
     * @var StoryModel
     */
    private $storyModel;

    public function __construct(StoryModel $storyModel)
    {
        $this->storyModel = $storyModel;
    }

    public function index() {

        /** @var StoryModel $storyModel */
        $storyModel = $this->storyModel;
        $stories = $storyModel->loadStories();
        
        $content = '<ol>';
        
        foreach($stories as $story) {

            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

