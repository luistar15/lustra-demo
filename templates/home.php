<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<h2>Top 10 genres</h2>

<ol>
<?php foreach ( $genres as $genre ) { ?>
	<li>
		<a href="<?=$router->urlFor( 'genres-details', ['genre_id' => $genre['GenreId'] ] )?>">
			<?=e($genre['Name'])?>
		</a>
		(<?=$genre['num_tracks']?> tracks)
	</li>
<?php } ?>
</ol>

<p>Explore <a href="<?=$router->urlFor( 'genres-list' )?>">all of the genres</a>.</p>

<h2>Top 10 artists</h2>

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

<p>Explore <a href="<?=$router->urlFor( 'artists-list' )?>">all of the artists</a>.</p>
