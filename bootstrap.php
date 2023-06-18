<?php

declare(strict_types=1);


use Site\Site;
use Lustra\ErrorHandler;
use Lustra\Container;
use Lustra\Web\Router\RouterFactory;


// ------------------------

require APP_DIR . '/vendor/autoload.php';


// ------------------------

$error_handler = new ErrorHandler();


// ------------------------

$container = new Container();

require APP_DIR . '/config/services.php';

$debug = $container->get( 'config' )['debug'];

$error_handler->setup( $debug, APP_DIR . '/var/log/error.log' );


// ------------------------

$router = RouterFactory::build(
	$container->get( 'config' )['site_base'],
	APP_DIR . '/config/routes.php',
	APP_DIR . '/var/cache/routes.cache.php'
);


// ------------------------

$app = new Site( $router, $container );

$error_handler->setHandler( [ $app, 'handleError' ] );

$app->setTemplateDir( APP_DIR . '/templates' );


// ------------------------

$app->run();
