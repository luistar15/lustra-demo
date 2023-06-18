<?php

declare(strict_types=1);


namespace Site\Model;


use Lustra\DB\ActiveRecord;


class AlbumModel extends ActiveRecord {

	protected string $table = 'Album';
	protected string $pk    = 'AlbumId';

	protected array $relations = [
		'Artist' => 'Album.ArtistId = Artist.ArtistId',
		'Track'  => 'Album.AlbumId = Track.AlbumId',
	];


	public function getAlbums( int $limit = -1 ) : array {
		$args = [
			'COLUMNS' => [ 'Album.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Track' ],
			'GROUP'   => [ 'Album.AlbumId' ],
			'ORDER'   => [ 'Album.Title ASC' ],
		];

		if ( $limit ) {
			$args['LIMIT'] = $limit;
		}

		return $this->find( $args );
	}


	public function getAlbumsByGenre( string $genre_id ) : array {
		$args = [
			'COLUMNS' => [ 'Album.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Track' ],
			'WHERE'   => [ 'Track.GenreId = :genre_id' ],
			'GROUP'   => [ 'Album.AlbumId' ],
			'ORDER'   => [ 'Album.Title ASC' ],
		];

		$bindings = [
			'genre_id' => $genre_id,
		];

		return $this->find( $args, $bindings );
	}


	public function getAlbumsByArtist( string $artist_id ) : array {
		$args = [
			'COLUMNS' => [ 'Album.*', 'COUNT(1) AS num_tracks' ],
			'JOIN'    => [ 'Track' ],
			'WHERE'   => [ 'Album.ArtistId = :artist_id' ],
			'GROUP'   => [ 'Album.AlbumId' ],
			'ORDER'   => [ 'Album.Title ASC' ],
		];

		$bindings = [
			'artist_id' => $artist_id,
		];

		return $this->find( $args, $bindings );
	}

}
