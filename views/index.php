<?php

$content = '<ol>';

foreach($this->stories as $story) {

    $content .= '
                <li>
                <a class="headline" href="' . $story->url . '">' . $story->headline . '</a><br />
                <span class="details">' . $story->created_by . ' | <a href="/story?id=' . $story->id . '">' . $story->comment_count . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story->created_on)) . '</span>
                </li>
            ';
}

$content .= '</ol>';

echo $content;