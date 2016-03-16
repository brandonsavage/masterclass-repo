<?php

namespace Masterclass\Domain\Story;

use DateTime;
use Masterclass\Domain\User\UserId;
use Masterclass\Domain\Value;
use Masterclass\Domain\ValueObject;

class Comment extends ValueObject implements Value
{
    protected $createdByUserId;
    protected $createdOn;
    protected $storyId;
    protected $text;

    public function __construct(UserId $createdByUserId, DateTime $createdOn, StoryId $storyId, string $text)
    {
        $this->createdByUserId = $createdByUserId;
        $this->createdOn = $createdOn;
        $this->storyId = $storyId;
        $this->setText($text);
    }

    public function setText($text)
    {
        $text = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (mb_strlen($text) > 5000) {
            throw new InvalidComment('Comments limited to 5000 characters');
        }
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getStoryId()
    {
        return $this->storyId;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getCreatedBy()
    {
        return $this->createdByUserId;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(Value $value)
    {
        return $value instanceof self && (string) $value === (string) $this;
    }
}
