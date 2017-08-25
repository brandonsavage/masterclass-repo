<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/25/17
 * Time: 11:20 AM
 */

namespace Masterclass\Model\Stories;


use Masterclass\Forms\FormFactory;
use Masterclass\Forms\StoryForm;

class StoryWriteService
{
    /**
     * @var StoryGateway
     */
    private $gateway;

    public function __construct(StoryGateway $gateway)
    {

        $this->gateway = $gateway;
    }

    public function createNewStory($headline, $url, $createdBy)
    {
        $storyForm = FormFactory::create(StoryForm::class);
        $storyForm->populateData([
            'headline' => $headline,
            'url' => $url,
            'created_by' => $createdBy,
        ]);

        if (!$storyForm->validate()) {
            //todo
            return;
        }

        return $this->gateway->createStory(
            $storyForm->getValue('headline'),
            $storyForm->getValue('url'),
            $storyForm->getValue('created_by')
        );
    }
}