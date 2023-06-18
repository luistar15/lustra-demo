<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / Albums
</p>

<ol>
	<?php foreach ( $albums as $album ) { ?>
	<li>
		<a href="<?=$router->urlFor( 'albums-details', [ 'album_id' => $album['AlbumId'] ] )?>">
			<?=e($album['Title'])?>
		</a>
		(<?=$album['num_tracks']?>)
	</li>
	<?php } ?>
</ol>
