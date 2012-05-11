<h2>Viewing #<?php echo $genre->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $genre->name; ?></p>

<p>
	<strong>Movies:</strong>
	<br />
	<?php
	if (count($genre->movies) == 0)
	{
		echo 'None';
	}
	else
	{
		foreach ($genre->movies as $m)
		{
			if (empty($m->poster))
			{
				echo "{$m->title} ({$m->released})";
			}
			else
			{
				echo Html::img($m->poster, array('width' => '90', 'height' => '120', 'title' => "{$m->title} ({$m->released})"));
			}
		}
	}
	?>
</p>

<?php echo Html::anchor('admin/genres/edit/' . $genre->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/genres', 'Back'); ?>