<?php

namespace Masterclass\Controller;

use PDO;

class Story {
    
    public function __construct($config) {
        $this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }
        
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->db->prepare($story_sql);
        $story_stmt->execute(array($_GET['id']));
        if($story_stmt->rowCount() < 1) {
            header("Location: /");
            exit;
        }
        
        $story = $story_stmt->fetch(PDO::FETCH_ASSOC);
        
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute(array($story['id']));
        $comment_count = $comment_stmt->rowCount();
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments | 
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';
        
        if(isset($_SESSION['AUTHENTICATED'])) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
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
        
        require_once $this->config['path'] . '/layout.phtml';
        
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
                $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                   $_POST['headline'],
                   $_POST['url'],
                   $_SESSION['username'],
                ));
                
                $id = $this->db->lastInsertId();
                header("Location: /story/?id=$id");
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
        
        require_once $this->config['path'] . '/layout.phtml';
    }
    
}