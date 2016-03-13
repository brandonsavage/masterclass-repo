<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story;

class Index
{
    
    protected $model;
    
    public function __construct(Story $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {

        $stories = $this->model->getAllStories();
//        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
//        $stmt = $this->db->prepare($sql);
//        $stmt->execute();
//        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $content = '<ol>';
        
        foreach ($stories as $story) {
//            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
//            $comment_stmt = $this->db->prepare($comment_sql);
//            $comment_stmt->execute(array($story['id']));
//            $count = $comment_stmt->fetch(PDO::FETCH_ASSOC);
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '/vagrant/layout.phtml';
    }
}
