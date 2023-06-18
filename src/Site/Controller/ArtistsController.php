<?php

declare(strict_types=1);


namespace Site\Controller;


use Site\Site;
use Site\Model\ArtistModel;
use Site\Model\GenreModel;
use Site\Model\AlbumModel;

use Lustra\DB\RecordNotFoundException;


class ArtistsController {

	public function list(
		Site $app,
		ArtistModel $artist_model
	) : void {

		$tpl_data = $app->initializeTemplateData();

		$tpl_data['page_title'] = 'Artists - Music Catalog';

		$tpl_data['artists'] = $artist_model->getArtists();

		$app->render( 'base', $tpl_data );
	}


	public function details(
		Site $app,
		ArtistModel $artist_model,
		GenreModel $genre_model,
		AlbumModel $album_model,
		string $artist_id
	) : void {

		try {
			$artist = $artist_model->loadByPk( $artist_id );

			$tpl_data = $app->initializeTemplateData();

			$tpl_data['page_title'] = "Artist: {$artist['Name']}";

			$tpl_data['genres'] = $genre_model->getGenresByArtist( $artist_id );
			$tpl_data['albums'] = $album_model->getAlbumsByArtist( $artist_id );
			$tpl_data['artist'] = $artist;

			$app->render( 'base', $tpl_data );

		} catch ( RecordNotFoundException $e ) {
			$app->displayErrorPage( 404, $e->getMessage() );
		}
	}

}
