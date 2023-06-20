<?php

declare(strict_types=1);


use Site\Site;

use Lustra\ErrorHandler;
use Lustra\Container;
use Lustra\Config;
use Lustra\Web\Router\RouterFactory;

use DebugBar\DebugBar;


// ------------------------

require APP_DIR . '/vendor/autoload.php';


// ------------------------

$error_handler = new ErrorHandler();


// ------------------------

$container = new Container();

require APP_DIR . '/config/services.php';

$config = $container->get( Config::class );

$error_handler->setup(
	$config->get( 'debug' ),
	APP_DIR . '/var/log/error.log'
);


// ------------------------

if ( $config->get( 'debug' ) ) {
	$container->get( DebugBar::class );
}


// ------------------------

$router = RouterFactory::build(
	$config->get( 'site_base' ),
	APP_DIR . '/config/routes.php',
	APP_DIR . '/var/cache/routes.cache.php'
);


// ------------------------

$app = new Site( $router, $container );

$error_handler->setHandler( [ $app, 'handleError' ] );

$app->setTemplateDir( APP_DIR . '/templates' );


// ------------------------

$app->run();
