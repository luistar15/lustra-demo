<?php

declare(strict_types=1);


namespace Site\Model;


use Lustra\DB\ActiveRecord;


class GenreModel extends ActiveRecord {

	protected string $table = 'Genre';
	protected string $pk    = 'GenreId';

	protected array $relations = [
		'Track' => 'Genre.GenreId = Track.GenreId',
		'Album' => 'Track.AlbumId = Album.AlbumId',
	];


	public function getGenres( int $limit = -1 ) : array {
		$args = [
			'COLUMNS' => [ 'Genre.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Track' ],
			'GROUP'   => [ 'Genre.GenreId' ],
			'ORDER'   => [ 'num_tracks DESC' ],
		];

		if ( $limit > 0 ) {
			$args['LIMIT'] = $limit;
		}

		return $this->find( $args );
	}


	public function getGenresByArtist( string $artist_id ) : array {
		$args = [
			'DISTINCT' => true,
			'COLUMNS'  => [ 'Genre.*' ],
			'JOIN'     => [ 'Track', 'Album' ],
			'WHERE'    => [ 'Album.ArtistId = :artist_id' ],
			'ORDER'    => [ 'Genre.Name ASC' ],
		];

		$bindings = [
			'artist_id' => $artist_id,
		];

		return $this->find( $args, $bindings );
	}

}
