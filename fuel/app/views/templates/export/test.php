<?php
foreach($movies as $movie)
{
	echo htmlspecialchars($movie->title)." ({$movie->released})\n";
}
?>
