<?php

declare(strict_types=1);


namespace Site\Model;


use Lustra\DB\ActiveRecord;


class ArtistModel extends ActiveRecord {

	protected string $table = 'Artist';
	protected string $pk    = 'ArtistId';

	protected array $relations = [
		'Album' => 'Artist.ArtistId = Album.ArtistId',
		'Track' => 'Album.AlbumId = Track.AlbumId',
	];


	public function getArtists( int $limit = -1 ) : array {
		$args = [
			'COLUMNS' => [ 'Artist.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Album', 'Track' ],
			'GROUP'   => [ 'Artist.ArtistId' ],
			'ORDER'   => [ 'num_tracks DESC' ],
		];

		if ( $limit > 0 ) {
			$args['LIMIT'] = $limit;
		}

		return $this->find( $args );
	}


	public function getArtistsByGenre( string $genre_id ) : array {
		$args = [
			'COLUMNS' => [ 'Artist.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Album', 'Track' ],
			'WHERE'   => [ 'Track.GenreId = :genre_id' ],
			'GROUP'   => [ 'Artist.ArtistId' ],
			'ORDER'   => [ 'Artist.Name ASC' ],
		];

		$bindings = [
			'genre_id' => $genre_id,
		];

		return $this->find( $args, $bindings );
	}

}
