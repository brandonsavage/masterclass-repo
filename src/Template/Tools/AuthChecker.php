<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/24/17
 * Time: 09:39
 */

namespace Masterclass\Template\Tools;


use Aura\Session\Session;

abstract class AuthChecker
{
    public static function checkAuth()
    {
        $session_factory = new \Aura\Session\SessionFactory;
        $session = $session_factory->newInstance($_COOKIE);
        $segment = $session->getSegment('Masterclass');
        return (bool)$segment->get('AUTHENTICATED');
    }
}