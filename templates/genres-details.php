<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / <a href="<?=$router->urlFor( 'genres-list' )?>">Genres</a>
   / <?=e($genre['Name'])?>
</p>

<h2>Artists</h2>
<ol>
	<?php foreach ( $artists as $artist ) { ?>
	<li>
		<a href="<?=$router->urlFor( 'artists-details', [ 'artist_id' => $artist['ArtistId'] ] )?>">
			<?=e($artist['Name'])?>
		</a>
		(<?=$artist['num_tracks']?> tracks)
	</li>
	<?php } ?>
</ol>

<h2>Albums</h2>
<ol>
	<?php foreach ( $albums as $album ) { ?>
	<li>
		<a href="<?=$router->urlFor( 'albums-details', [ 'album_id' => $album['AlbumId'] ] )?>">
			<?=e($album['Title'])?>
		</a>
		(<?=$album['num_tracks']?> tracks)
	</li>
	<?php } ?>
</ol>
