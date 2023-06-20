<?php

use Lustra\Container;
use Lustra\Config;
use Lustra\DB\DBAL;

use Site\Page;
use Site\Model\GenreModel;
use Site\Model\ArtistModel;
use Site\Model\AlbumModel;
use Site\Model\TrackModel;

use DebugBar\DebugBar;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DataCollector\PDO\PDOCollector;


$container->add(
	Config::class,
	function () : Config {
		$config = new Config();

		$config->loadIni(
			APP_DIR . '/config/config.ini'
		);

		$config->loadIni(
			sprintf(
				APP_DIR . '/config/config.%s.ini',
				getenv( 'APP_ENV' ) ?: 'dev'
			)
		);

		$config->loadEnv(
			[
				'global' => [
					'APP_ENV' => 'app_env',
				],
			]
		);

		$replaces = [
			'APP_DIR' => APP_DIR,
		];

		$config->replacePlaceholders( $replaces );

		return $config;
	}
);


if ( $container->get( Config::class )->get( 'debug' ) ) {
	$container->add(
		DebugBar::class,
		function () : DebugBar {
			$debugbar = new DebugBar();
			$debugbar->addCollector( new TimeDataCollector() );
			$debugbar->addCollector( new MemoryCollector() );

			return $debugbar;
		}
	);
}


$container->add(
	DBAL::class,
	function ( Container $container ) : DBAL {
		$config = $container->get( Config::class );

		$dbal = new DBAL( $config->get( 'database' ) );

		if ( $config->get( 'debug' ) ) {
			$dbal->connect();

			$traceable_pdo = new TraceablePDO( $dbal );

			$container->get( DebugBar::class )->addCollector(
				new PDOCollector( $traceable_pdo )
			);
		}

		return $dbal;
	}
);


$container->add(
	Page::class,
	fn () : Page => new Page()
);


$container->add(
	GenreModel::class,
	fn ( Container $c ) : GenreModel => new GenreModel( $c->get( DBAL::class ) )
);


$container->add(
	ArtistModel::class,
	fn ( Container $c ) : ArtistModel => new ArtistModel( $c->get( DBAL::class ) )
);


$container->add(
	AlbumModel::class,
	fn ( Container $c ) : AlbumModel => new AlbumModel( $c->get( DBAL::class ) )
);


$container->add(
	TrackModel::class,
	fn ( Container $c ) : TrackModel => new TrackModel( $c->get( DBAL::class ) )
);
