<?php

declare(strict_types=1);


namespace Site\Controller;


use Site\Site;
use Site\Model\GenreModel;
use Site\Model\ArtistModel;
use Site\Model\AlbumModel;

use Lustra\DB\RecordNotFoundException;


class GenresController {

	public function list(
		Site $app,
		GenreModel $genre_model
	) : void {

		$tpl_data = $app->initializeTemplateData();

		$tpl_data['page_title'] = 'Genres - Music Catalog';

		$tpl_data['genres'] = $genre_model->getGenres();

		$app->setup();
		$app->render( 'base', $tpl_data );
	}


	public function details(
		Site $app,
		GenreModel $genre_model,
		ArtistModel $artist_model,
		AlbumModel $album_model,
		string $genre_id
	) : void {

		try {
			$genre = $genre_model->loadByPk( $genre_id );

			$tpl_data = $app->initializeTemplateData();

			$tpl_data['page_title'] = "Genre: {$genre['Name']}";

			$tpl_data['genre']   = $genre;
			$tpl_data['artists'] = $artist_model->getArtistsByGenre( $genre_id );
			$tpl_data['albums']  = $album_model->getAlbumsByGenre( $genre_id );

			$app->setup();
			$app->render( 'base', $tpl_data );

		} catch ( RecordNotFoundException $e ) {
			$app->displayErrorPage( 404, $e->getMessage() );
		}
	}

}
