<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / Artists
</p>

<ol>
	<?php foreach ( $artists as $artist ) { ?>
	<li>
		<a href="<?=$router->urlFor( 'artists-details', [ 'artist_id' => $artist['ArtistId'] ] )?>">
			<?=e($artist['Name'])?>
		</a>
		(<?=$artist['num_tracks']?>)
	</li>
	<?php } ?>
</ol>
