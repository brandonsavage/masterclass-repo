<?php

namespace Masterclass\Domain\Story;

interface CommentDataStore
{
    public function addComment($username, $storyId, $comment);
    public function getCommentsForStoryId($storyId);
}
