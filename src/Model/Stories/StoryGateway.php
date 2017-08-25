<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 15:01
 */

namespace Masterclass\Model\Stories;


class StoryGateway
{
    /**
     * @var StoryStorage
     */
    protected $storage;

    public function __construct(StoryStorage $storage)
    {
        $this->storage = $storage;
    }

    public function loadStories()
    {
        $stories = $this->storage->getRawStoryData();

        $storyCollection = new Stories();

        foreach ($stories as $story) {
            $storyCollection->addEntity(new Story($story));
        }

        return $storyCollection;
    }

    public function fetchStory($storyId)
    {
        $storyData = $this->storage->getSingleStoryData($storyId);

        if (!$storyData) {
            throw new \InvalidArgumentException('Story ' . $storyId . ' does not exist');
        }

        return new Story($storyData);
    }

    public function createStory($headline, $url, $creator)
    {
        $story = new Story();
        $story->headline = $headline;
        $story->url = $url;
        $story->created_by = $creator;

        if ($story->validate()) {

            $result = $this->storage->createStory($story->headline, $story->url, $story->created_by);

            if (!$result) {
                throw new \Exception('There was a problem creating the story');
            }

            return new Story($result);
        }
    }
}