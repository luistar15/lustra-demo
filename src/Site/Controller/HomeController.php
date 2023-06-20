<?php

declare(strict_types=1);


namespace Site\Controller;


use Site\Site;
use Site\Model\ArtistModel;
use Site\Model\GenreModel;


class HomeController {

	public function __invoke(
		Site $app,
		GenreModel $genre_model,
		ArtistModel $artist_model
	) : void {

		$tpl_data = $app->initializeTemplateData();

		$tpl_data['page_title'] = 'Music Catalog';

		$tpl_data['genres']  = $genre_model->getGenres( 10 );
		$tpl_data['artists'] = $artist_model->getArtists( 10 );

		$app->setup();
		$app->render( 'base', $tpl_data );
	}

}
