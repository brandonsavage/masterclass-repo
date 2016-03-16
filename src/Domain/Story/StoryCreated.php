<?php

namespace Masterclass\Domain\Story;

use Masterclass\Domain\DomainEvent;

class StoryCreated extends DomainEvent
{
    const NAME = 'StoryCreated';
}
