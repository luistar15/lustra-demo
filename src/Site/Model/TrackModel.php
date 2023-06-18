<?php

declare(strict_types=1);


namespace Site\Model;


use Lustra\DB\ActiveRecord;


class TrackModel extends ActiveRecord {

	protected string $table = 'Track';
	protected string $pk    = 'TrackId';

	protected array $relations = [
		'Genre' => 'Track.GenreId = Genre.GenreId',
	];


	public function getTracksByAlbum( string $album_id ) : array {
		$args = [
			'COLUMNS' => [ 'Track.*', 'Genre.Name AS Genre' ],
			'JOIN'    => [ 'Genre' ],
			'WHERE'   => [ 'Track.AlbumId = :album_id' ],
			'ORDER'   => [ 'Track.Name ASC' ],
		];

		$bindings = [
			'album_id' => $album_id,
		];

		return $this->find( $args, $bindings );
	}

}
