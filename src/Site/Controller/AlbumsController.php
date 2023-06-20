<?php

declare(strict_types=1);


namespace Site\Controller;


use Site\Site;
use Site\Model\ArtistModel;
use Site\Model\AlbumModel;
use Site\Model\TrackModel;

use Lustra\DB\RecordNotFoundException;


class AlbumsController {

	public function list(
		Site $app,
		AlbumModel $album_model
	) : void {

		$tpl_data = $app->initializeTemplateData();

		$tpl_data['page_title'] = 'Albums';

		$tpl_data['albums'] = $album_model->getAlbums();

		$app->setup();
		$app->render( 'base', $tpl_data );
	}


	public function details(
		Site $app,
		AlbumModel $album_model,
		ArtistModel $artist_model,
		TrackModel $track_model,
		string $album_id
	) : void {

		try {
			$album  = $album_model->loadByPk( $album_id );
			$artist = $artist_model->loadByPk( strval( $album['ArtistId'] ) );

			$tpl_data = $app->initializeTemplateData();

			$tpl_data['page_title'] = "Album: {$album['Title']} ({$artist['Name']})";

			$tpl_data['album']  = $album;
			$tpl_data['artist'] = $artist;
			$tpl_data['tracks'] = $track_model->getTracksByAlbum( $album_id );

			$app->setup();
			$app->render( 'base', $tpl_data );

		} catch ( RecordNotFoundException $e ) {
			$app->displayErrorPage( 404, $e->getMessage() );
		}
	}

}
