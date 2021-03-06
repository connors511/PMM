<h2>Viewing #<?php echo $movie->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $movie->title; ?></p>
<p>
	<strong>Plot:</strong>
	<?php echo $movie->plot; ?></p>
<p>
	<strong>Plotsummary:</strong>
	<?php echo $movie->plotsummary; ?></p>
<p>
	<strong>Tagline:</strong>
	<?php echo $movie->tagline; ?></p>
<p>
	<strong>Rating:</strong>
	<?php echo $movie->rating; ?></p>
<p>
	<strong>Votes:</strong>
	<?php echo $movie->votes; ?></p>
<p>
	<strong>Released:</strong>
	<?php echo $movie->released; ?></p>
<p>
	<strong>Runtime:</strong>
	<?php if ($movie->runtime) echo Time::time_elapsed_min($movie->runtime); ?></p>
<p>
	<strong>Runtime file:</strong>
	<?php echo $movie->runtime_file; ?></p>
<p>
	<strong>Contentrating:</strong>
	<?php echo $movie->contentrating; ?></p>
<p>
	<strong>Originaltitle:</strong>
	<?php echo $movie->originaltitle; ?></p>
<p>
	<strong>Trailer url:</strong>
	<?php echo $movie->trailer_url; ?></p>
<p>
	<strong>Poster:</strong><br />
	<img src="<?php echo $movie->poster->get_thumb_url(92, 138); ?>" style="margin: 5px"/>
</p>
<p>
	<strong>File:</strong>
	<?php echo $movie->file->path; ?></p>

<p>
	<strong>Fanart:</strong><br />
	<?php foreach($movie->fanart as $fanart): ?>
		<img src="<?php echo $fanart->get_thumb_url(); ?>" style="margin: 5px"/>
	<?php endforeach; ?>
</p>

<?php echo Html::anchor('admin/movies/edit/'.$movie->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/movies', 'Back'); ?>