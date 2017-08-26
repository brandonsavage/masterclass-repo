<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/26/17
 * Time: 8:58 AM
 */

namespace Masterclass\Action;


use Masterclass\Model\Stories\StoryReadService;

class IndexAction
{
    /**
     * @var StoryReadService
     */
    private $storyRead;

    public function __construct(StoryReadService $storyRead)
    {

        $this->storyRead = $storyRead;
    }

    public function index()
    {
        return $this->storyRead->getStories();
    }
}