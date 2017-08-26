<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 17:34
 */

namespace Masterclass\Command\Handlers;


use Masterclass\Command\Handlers\CommandHandlerInterface;
use Masterclass\Event\EventDispatcher;
use Masterclass\Event\Events\UserCreated;
use Masterclass\Model\Users\UserGateway;

class CreateUser implements CommandHandlerInterface
{
    /**
     * @var UserGateway
     */
    protected $userGateway;

    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function execute($command)
    {
        $result = $this->userGateway->createUser(
            $command->username,
            $command->password,
            $command->email
        );

        if ($result) {
            EventDispatcher::dispatch(new UserCreated($command->username));
        }

        return $result;
    }
}