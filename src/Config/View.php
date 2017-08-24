<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/24/17
 * Time: 10:00
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;

class View extends Config
{
    public function define(Container $di)
    {
        $tm = require(realpath('../config/template_map.php'));

        $di->params['Aura\View\View'] = array(
            'view_registry'   => $di->lazyNew('Aura\View\TemplateRegistry', ['map' => $tm['templates']]),
            'layout_registry' => $di->lazyNew('Aura\View\TemplateRegistry', ['map' => $tm['layouts']]),
            'helpers'         => $di->lazyNew('Aura\View\HelperRegistry'),
        );

        $di->set('View', $di->lazyNew('Aura\View\View'));
    }
}