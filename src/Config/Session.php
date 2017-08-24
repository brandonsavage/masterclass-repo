<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/24/17
 * Time: 09:23
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;

class Session extends Config
{
    public function define(Container $di)
    {
        /**
         * Services
         */
        $di->set('Session', $di->lazyNew('Aura\Session\Session'));

        /**
         * Aura\Session\CsrfTokenFactory
         */
        $di->params['Aura\Session\CsrfTokenFactory']['randval'] = $di->lazyNew('Aura\Session\Randval');

        /**
         * Aura\Session\Session
         */
        $di->params['Aura\Session\Session'] = array(
            'segment_factory' => $di->lazyNew('Aura\Session\SegmentFactory'),
            'csrf_token_factory' => $di->lazyNew('Aura\Session\CsrfTokenFactory'),
            'cookies' => $_COOKIE,
            'phpfunc' => $di->lazyNew('Aura\Session\Phpfunc'),
        );

        /**
         * Aura\Session\Randval
         */
        $di->params['Aura\Session\Randval']['phpfunc'] = $di->lazyNew('Aura\Session\Phpfunc');

        /**
         * Aura\Session\Segment
         */
        $di->params['Aura\Session\Segment'] = array(
            'session' => $di->lazyGet('aura/session:session'),
        );
    }
}