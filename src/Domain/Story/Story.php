<?php

namespace Masterclass\Domain\Story;

use DateTime;
use Masterclass\Domain\User\UserId;
use Masterclass\Domain\Value;
use Masterclass\Domain\ValueObject;

class Story extends ValueObject implements Value
{
    protected $storyId;
    protected $headline;
    protected $url;
    protected $createdByUserId;
    protected $createdOn;
    protected $commentCollection;

    public function __construct(
        StoryId $id,
        string $headline,
        string $url,
        UserId $createdByUserId,
        DateTime $createdOn,
        CommentCollection $commentCollection
    ) {
        $this->storyId = $id;
        $this->headline = $this->setHeadline($headline);
        $this->url = $this->setUrl($url);
        $this->createdByUserId = $createdByUserId;
        $this->createdOn = $createdOn;
        $this->commentCollection = $commentCollection;
    }

    public function addComment(Comment $comment)
    {
        $this->commentCollection->addComment($comment);
    }

    public function getId()
    {
        return $this->storyId;
    }

    protected function setHeadline($headline)
    {
        $headline = filter_var($headline, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($headline === '') {
            throw new InvalidStory('Headline must be set');
        }

        if (mb_strlen($headline) > 500) {
            throw new InvalidStory('Headline must be 500 characters or less');
        }

        $this->headline = $headline;
    }

    protected function setUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidStory('URL is invalid');
        }
        $this->url = $url;
    }

    public function equals(Value $value)
    {
        return $value instanceof self && (string) $value === (string) $this;
    }
}
