<?php
// TODO: Depend on user preferences?
?>
<b>Year:</b> <?php echo $movie->released; ?><br />
<b>Tagline:</b> <?php echo $movie->tagline; ?><br />
<b>Runtime:</b> <?php echo $movie->runtime; ?><br />
<b>Rating: </b> <?php echo "{$movie->rating} ({$movie->votes} votes)"; ?><br />
<b>Plot:</b> <?php echo Str::truncate($movie->plot,300); ?>