<?php

use Lustra\Container;
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
	'config',
	array_merge(
		require APP_DIR . '/config/config.base.php',
		require APP_DIR . sprintf(
			'/config/config.%s.php',
			getenv( 'APP_ENV' ) ?: 'dev'
		)
	)
);


if ( $container->get( 'config' )['debug'] ) {
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
		$pdo = new DBAL( ...$container->get( 'config' )['db'] );

		if ( $container->get( 'config' )['debug'] ) {
			$pdo->connect();

			$traceable_pdo = new TraceablePDO( $pdo );

			$container->get( DebugBar::class )->addCollector(
				new PDOCollector( $traceable_pdo )
			);
		}

		return $pdo;
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
