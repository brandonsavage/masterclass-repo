<?php

$story = $this->story;

$content = '
<a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
<span class="details">' . $story['created_by'] . ' | ' . $this->comment_count . ' Comments |
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
';

if($this->authenticated) {
$content .= '
<form method="post" action="/comment/create">
    <input type="hidden" name="story_id" value="' . $story['id'] . '" />
    <textarea cols="60" rows="6" name="comment"></textarea><br />
    <input type="submit" name="submit" value="Submit Comment" />
</form>
';
}

foreach($this->comments as $comment) {
$content .= '
<div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
    ' . $comment['comment'] . '</div>
';
}

echo $content;