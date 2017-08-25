<?php

namespace Masterclass\Model\Stories;

use Masterclass\Model\Stories\Exceptions\HeadlineNotProvided;
use Masterclass\Model\Stories\Exceptions\StoryCreatorMissing;
use Masterclass\Model\Stories\Exceptions\UrlNotValid;

class Story
{
    public $id;
    public $headline;
    public $url;
    public $created_on;
    public $created_by;

    public $comment_count;

    protected $excluded = ['excluded', 'comment_count'];

    public function __construct(array $args = [])
    {
        foreach ($args as $key => $property) {
            if (property_exists($this, $key)) {
                $this->$key = $property;
            }
        }
    }

    public function toArray()
    {
        $data = [];

        foreach($this as $key => $value) {
            if (!in_array($key, $this->excluded)) {
                $data[$key] = $value;
            }
        }

        // To make saving easier.
        if (empty($data['id'])) {
            unset($data['id']);
        }

        return $data;
    }

    public function validate()
    {
        if (!$this->headline) {
            throw new HeadlineNotProvided('No headline was provided');
        }

        // Let's sanitize the headline since we know we have one.
        $this->headline = filter_var($this->headline, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (!$this->url || !filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new UrlNotValid('The URL was not valid or missing');
        }

        if (!$this->created_by) {
            throw new StoryCreatorMissing('The creator was not specified');
        }

        return true;
    }
}