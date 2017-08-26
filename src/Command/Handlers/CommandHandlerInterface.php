<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 17:26
 */

namespace Masterclass\Command\Handlers;


interface CommandHandlerInterface
{
    public function execute($command);
}