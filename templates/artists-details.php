<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / <a href="<?=$router->urlFor( 'artists-list' )?>">Artists</a>
   / <?=e($artist['Name'])?>
</p>

<h2>Artist info</h2>
<ul>
	<li><strong>Name</strong>: <?=e($artist['Name'])?></li>
	<li>
		<strong>Genres</strong>:
		<?php foreach ($genres as $genre) { ?>
		<a href="<?=$router->urlFor( 'genres-details', [ 'genre_id' => $genre['GenreId'] ] )?>"><?=e($genre['Name'])?></a>,
		<?php } ?>
	</li>
	<li><strong>Tracks</strong>: <?=array_sum( array_column( $albums, 'num_tracks' ) )?></li>
</ul>

<h2>Albums</h2>
<ol>
	<?php foreach ($albums as $album) { ?>
	<li>
		<a href="<?=$router->urlFor( 'albums-details', [ 'album_id' => $album['AlbumId'] ] )?>">
			<?=e($album['Title'])?>
		</a>
		(<?=$album['num_tracks']?> tracks)
	</li>
	<?php } ?>
</ol>
