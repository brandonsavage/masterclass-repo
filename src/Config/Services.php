<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 12:06
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use PDO;

class Services extends Config
{
    public function define(Container $di)
    {
        $di->params[\Masterclass\Request::class] = [
            'globals' => $GLOBALS,
        ];

        $di->set('Router', function () use ($di) {
            $config = $di->get('config');

            $routes = [];

            foreach ($config['routes'] as $path => $route) {
                if ($route['method'] == 'GET') {
                    $route = new \Masterclass\Router\Routes\GetRoute($path, $route);
                } else {
                    $route = new \Masterclass\Router\Routes\PostRoute($path, $route);
                }

                $routes[] = $route;
            }

            return new \Masterclass\Router\Router($di->newInstance(\Masterclass\Request::class), $routes);
        });

        $di->set('Pdo', function() use ($di) {
            $config = $di->get('config');
            $dbconfig = $config['database'];
            $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
            $db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        });

        $di->set('Request', function () {
            return \Zend\Diactoros\ServerRequestFactory::fromGlobals();
        });
    }
}