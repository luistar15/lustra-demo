<?php

use Lustra\Container;
use Lustra\DB\DBAL;

use Site\Model\GenreModel;
use Site\Model\ArtistModel;
use Site\Model\AlbumModel;
use Site\Model\TrackModel;


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


$container->add(
	DBAL::class,
	fn ( Container $c ) => new DBAL( ...$c->get( 'config' )['db'] )
);


$container->add(
	GenreModel::class,
	fn ( Container $c ) => new GenreModel( $c->get( DBAL::class ) )
);


$container->add(
	ArtistModel::class,
	fn ( Container $c ) => new ArtistModel( $c->get( DBAL::class ) )
);


$container->add(
	AlbumModel::class,
	fn ( Container $c ) => new AlbumModel( $c->get( DBAL::class ) )
);


$container->add(
	TrackModel::class,
	fn ( Container $c ) => new TrackModel( $c->get( DBAL::class ) )
);
