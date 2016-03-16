<?php

namespace Masterclass\Domain\Story;

class CommentCollection
{
    protected $comments;

    public function __construct(Comment ...$comments)
    {
        foreach ($comments as $comment) {
            $this->comments[] = $comment;
        }
    }

    public function getComments()
    {
        return $this->getComments();
    }

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }
}
