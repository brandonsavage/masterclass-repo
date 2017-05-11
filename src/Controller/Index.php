<?php
namespace Masterclass\Controller;

use Masterclass\Model\Story as Model_Story;

class Index
{
    /**
     * @var Model_Story
     */
    protected $story_model;

    public function __construct(Model_Story $story_model)
    {
        $this->story_model = $story_model;
    }

    public function index()
    {
        $content = '<ol>';

        $stories = $this->story_model->getAllStories();
        foreach ($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }

        $content .= '</ol>';

        require __DIR__ . '/../../layout.phtml';
    }
}

