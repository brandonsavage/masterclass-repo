<?php

namespace Masterclass\Model\Stories;

use Aura\Payload\PayloadFactory;
use Aura\Payload_Interface\PayloadStatus;
use Masterclass\Model\Stories\Exceptions\StoryIdNotInteger;

class StoryReadService
{
    /**
     * @var StoryGateway
     */
    private $gateway;
    /**
     * @var PayloadFactory
     */
    private $payloadFactory;

    public function __construct(StoryGateway $gateway, PayloadFactory $payloadFactory)
    {

        $this->gateway = $gateway;
        $this->payloadFactory = $payloadFactory;
    }

    public function getStories()
    {
        $payload = $this->payloadFactory->newInstance();
        $stories = $this->gateway->loadStories();
        $payload->setStatus(PayloadStatus::FOUND)->setOutput($stories);
        return $payload;
    }

    public function getStory($id)
    {
        if (!is_numeric($id)) {
            throw new StoryIdNotInteger('Story ID was not integer');
        }

        return $this->gateway->fetchStory($id);
    }
}