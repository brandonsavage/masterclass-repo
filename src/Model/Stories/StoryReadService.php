<?php

namespace Masterclass\Model\Stories;

use Masterclass\Model\Stories\Exceptions\StoryIdNotInteger;

class StoryReadService
{
    /**
     * @var StoryGateway
     */
    private $gateway;

    public function __construct(StoryGateway $gateway)
    {

        $this->gateway = $gateway;
    }

    public function getStories()
    {
        return $this->gateway->loadStories();
    }

    public function getStory($id)
    {
        if (!is_numeric($id)) {
            throw new StoryIdNotInteger('Story ID was not integer');
        }

        return $this->gateway->fetchStory($id);
    }
}