<h2>Viewing #<?php echo $scrapergroup_movie->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $scrapergroup_movie->name; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $scrapergroup_movie->title; ?></p>
<p>
	<strong>Plot:</strong>
	<?php echo $scrapergroup_movie->plot; ?></p>
<p>
	<strong>Plotsummary:</strong>
	<?php echo $scrapergroup_movie->plotsummary; ?></p>
<p>
	<strong>Tagline:</strong>
	<?php echo $scrapergroup_movie->tagline; ?></p>
<p>
	<strong>Rating:</strong>
	<?php echo $scrapergroup_movie->rating; ?></p>
<p>
	<strong>Votes:</strong>
	<?php echo $scrapergroup_movie->votes; ?></p>
<p>
	<strong>Released:</strong>
	<?php echo $scrapergroup_movie->released; ?></p>
<p>
	<strong>Runtime:</strong>
	<?php echo $scrapergroup_movie->runtime; ?></p>
<p>
	<strong>Contentrating:</strong>
	<?php echo $scrapergroup_movie->contentrating; ?></p>
<p>
	<strong>Originaltitle:</strong>
	<?php echo $scrapergroup_movie->originaltitle; ?></p>
<p>
	<strong>Trailer url:</strong>
	<?php echo $scrapergroup_movie->trailer_url; ?></p>

<?php echo Html::anchor('admin/scrapergroup/movie/edit/'.$scrapergroup_movie->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/scrapergroup/movie', 'Back'); ?>