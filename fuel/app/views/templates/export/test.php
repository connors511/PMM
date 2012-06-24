<?php
echo count($movies)." movies<br>\n";
foreach($movies as $movie)
{
	echo "Name: {$movie->title}<br>\n";
	echo "Year: {$movie->released}<br>\n";
	echo "Path: {$movie->file->path}<br>\n";
}
?>
