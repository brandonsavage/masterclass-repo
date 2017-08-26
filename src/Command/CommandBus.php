<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 17:24
 */

namespace Masterclass\Command;


use Masterclass\Command\Handlers\CommandHandlerInterface;

class CommandBus
{
    protected $commandHandlers = [];

    public function __construct(array $commandHandlers)
    {
        foreach ($commandHandlers as $command => $handler) {
            $this->loadCommandHandler($command, $handler);
        }
    }

    public function loadCommandHandler($command, CommandHandlerInterface $handler)
    {
        $this->commandHandlers[$command] = $handler;
    }

    public function perform($command)
    {
        $commandClass = get_class($command);

        if (isset($this->commandHandlers[$commandClass])) {
            $commandHandler = $this->commandHandlers[$commandClass];
            return $commandHandler->execute($command);
        }

        throw new \InvalidArgumentException($command . ' was not found');
    }
}