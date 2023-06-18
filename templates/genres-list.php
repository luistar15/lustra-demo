<?php use function htmlspecialchars as e; ?>

<h1><?=e($page_title)?></h1>

<p>/ <a href="<?=$router->urlFor( 'home' )?>">Music Catalog</a>
   / Genres
</p>

<ol>
	<?php foreach ($genres as $genre) { ?>
	<li>
		<a href="<?=$router->urlFor( 'genres-details', [ 'genre_id' => $genre['GenreId'] ] )?>">
			<?=e($genre['Name'])?>
		</a>
		(<?=$genre['num_tracks']?>)
	</li>
	<?php } ?>
</ol>
