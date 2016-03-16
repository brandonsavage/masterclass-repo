<?php

namespace Masterclass\Domain\Story;


interface StoryDataStore
{

    public function getAllStories();
    public function loadStoryById($storyId);
    public function createStory($headline, $url, $username);

    public function getNextId();
}
