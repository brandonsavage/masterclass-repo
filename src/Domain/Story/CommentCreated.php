<?php

namespace Masterclass\Domain\Story;

use Masterclass\Domain\DomainEvent;

class CommentCreated extends DomainEvent
{
    const NAME = 'CommentCreated';
}
