<h2>Editing Movie</h2>
<br>

<?php echo render('admin/movies/_form'); ?>
<p>
	<?php echo Html::anchor('admin/movies/view/'.$movie->id, 'View'); ?> |
	<?php echo Html::anchor('admin/movies', 'Back'); ?></p>
