<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 11:20 AM
 */

namespace Masterclass\Model\Stories;


use Aura\Payload\PayloadFactory;
use Aura\Payload_Interface\PayloadInterface;
use Aura\Payload_Interface\PayloadStatus;
use Masterclass\Forms\FormFactory;
use Masterclass\Forms\StoryForm;

class StoryWriteService
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

    public function createNewStory($headline, $url, $createdBy)
    {
        $storyForm = FormFactory::create(StoryForm::class);
        $storyForm->populateData([
            'headline' => $headline,
            'url' => $url,
            'created_by' => $createdBy,
        ]);

        $payload = $this->payloadFactory->newInstance();

        if (!$storyForm->validate()) {
            $payload->setStatus(PayloadStatus::NOT_VALID)->setOutput($storyForm->getErrors());
            return $payload;
        }

        try {
            $story = $this->gateway->createStory(
                $storyForm->getValue('headline'),
                $storyForm->getValue('url'),
                $storyForm->getValue('created_by')
            );

            $payload->setStatus(PayloadStatus::CREATED)->setOutput($story);
            return $payload;
        } catch (\Exception $e) {
            $payload->setStatus(PayloadStatus::ERROR)->setOutput($e);
        }


    }
}