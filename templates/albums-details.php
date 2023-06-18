<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / <a href="<?=$router->urlFor( 'albums-list' )?>">Albums</a>
   / <?=e($album['Title'])?>
</p>

<h2>Album info</h2>

<ul>
	<li><strong>Artist</strong>: <a href="<?=$router->urlFor( 'artists-details', [ 'artist_id' => $artist['ArtistId'] ] )?>"><?=e($artist['Name'])?></a></li>
	<li><strong>Tracks</strong>: <?=count($tracks)?></li>
	<li><strong>Duration</strong>: <?=gmdate( 'H:i:s', round( array_sum( array_column( $tracks, 'Milliseconds' ) ) / 1000 ) )?></li>
</ul>

<h2>Tracks</h2>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Genre</th>
			<th>Composer</th>
			<th>Duration</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $tracks as $i => $track ) { ?>
		<tr>
			<td><?=($i+1)?></td>
			<td><?=e($track['Name'])?></td>
			<td><a href="<?=$router->urlFor( 'genres-details', [ 'genre_id' => $track['GenreId'] ] )?>"><?=e($track['Genre'])?></a></td>
			<td><?=e($track['Composer']?:'')?></td>
			<td><?=gmdate( 'i:s', round( $track['Milliseconds'] / 1000 ) )?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
