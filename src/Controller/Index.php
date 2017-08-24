<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as StoryModel;
use Masterclass\ModelLocator;
use Masterclass\Request;
use PDO;

class Index {
    
    protected $db;
    
    public function __construct(Request $request, PDO $pdo) {
        $this->db = $pdo;
    }
    
    public function index() {

        /** @var StoryModel $storyModel */
        $storyModel = ModelLocator::loadModel(StoryModel::class);
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

