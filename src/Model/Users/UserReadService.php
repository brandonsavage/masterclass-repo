<?php

namespace Masterclass\Model\Users;

use Aura\Session\Session;
use Masterclass\Model\Users\Exceptions\UsernameNotProvided;
use Masterclass\Model\Users\Exceptions\UserNotLoggedIn;

class UserReadService
{
    /**
     * @var UserGateway
     */
    private $gateway;

    /**
     * @var Session
     */
    private $session;

    public function __construct(UserGateway $gateway, Session $session)
    {
        $this->gateway = $gateway;
        $this->session = $session;
    }

    public function findLoggedInUser()
    {
        $segment = $this->session->getSegment('Masterclass');
        $username = $segment->get('username');

        if (!$segment->get('AUTHENTICATED')) {
            throw new UserNotLoggedIn('User was not authenticated');
        }

        if (!$username) {
            throw new UsernameNotProvided('No username was found');
        }

        return $this->gateway->findUserByUsername($username);
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->gateway->checkUserAuthentication($username, $password);

        // Since we did not get an exception, we can move on.
        $this->session->regenerateId();
        $segment = $this->session->getSegment('Masterclass');
        $segment->set('username', $user->username);
        $segment->set('AUTHENTICATED', true);
        return $user;

    }
}