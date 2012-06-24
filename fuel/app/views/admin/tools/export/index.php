<?php
echo Form::open();
?>

<div class="row">
	<div class="span12">
		<h2>Export type</h2>
		<p>Each export type has unique options. Select a type, then options before exporting</p>
		<?php
		$selects = array(
		    'choose' => 'Choose type',
		    'Lists' => array(
			'fields' => 'Missing field(s)',
			'all' => 'All movies',
		    ),
		    'files' => 'Files'
		);
		echo Form::select('export_type', 'choose', $selects);
		?>
		<div id="select_fields">
			<p>Export a list with movies that are missing the following fields</p>
			<?php
			$fields = array(
			'plot' => 'Plot',
			'plotsummary' => 'Plot summary',
			'tagline' => 'Tagline',
			'rating' => 'Rating',
			'votes' => 'Votes',
			'released' => 'Released',
			'runtime' => 'Runtime',
			'contentrating' => 'Content rating',
			'originaltitle' => 'Original title',
			'thumb' => 'Thumb',
			'fanart' => 'Fanart',
			'trailer_url' => 'Trailer url',
			'poster' => 'Poster'
			);
			foreach($fields as $k => $v):
			?>
				<label class="checkbox">
					<input type="checkbox" name="missing_fields[]" value="<?php echo $k; ?>" class="by_field"> <?php echo $v; ?>
				</label>
			<?php
			endforeach;
			?>
		</div>
		<div id="export_template">
			<p>Choose an export template</p>
			<?php
			$files = File::read_dir(APPPATH.'views'.DS.'templates'.DS.'export', 0);
			echo Form::select('export_template', null, $files);
			echo Form::label('Or create your own', 'export_template_user');
			echo Form::textarea('export_template_user', '', array('rows' => 6, 'cols' => 8));
			
			$exts = array(
			    'xml' => 'XML',
			    'html' => 'HTML'
			);
			echo Form::label('Choose file extension', 'export_file_ext');
			echo Form::select('export_file_ext', null, $exts);
			?>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="span8">
		<h2>Options</h2>
		<p>Select save locations or keep config</p>
		<p>Select files to export; posters, covers, nfo, fanart, subtitles</p>
		<p>Export files or create a list of movies from a template</p>
		<p>Export list based on criterias such as rating</p>
	</div>
	<div class="span4">
		<h2>Export</h2>
		<?php echo Form::submit('submit', 'Export', array('class' => 'btn btn-primary')); ?>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6">
		<h2>Toggle by first letter</h2>
		<div class="row">
			<?php 
			$range = range('A','Z');
			$range = array_merge($range, array('#','All'));
			$i = 0;
			$switch = ceil(count($range) / 3);
			foreach($range as $letter): 
				if ($i % $switch == 0) {
					echo "<div class='span2'>";
				}
				$i++;
			?>
			<label class="checkbox">
				<input type="checkbox" value="<?php echo $letter; ?>" class="by_letter"> <?php echo $letter; ?>
			</label>
			<?php 
			if ($i % $switch == 0 or $i == count($range)) {
				echo "</div>";
			}
			endforeach;
			?>
		</div>
		
	</div>
	<div class="span6">
		<h2>Toggle by year</h2>
		<div class="row">
			<?php
			$range = range($year['max'], $year['max'] - 10);
			// TODO: Seems to skip over 1940, even if present as year[min]
			$range = array_merge($range, range($year['max'] - 11, $year['min'], 10), array('All'));
			$i = 0;
			$switch = ceil(count($range) / 3);
			foreach($range as $k=>$r):
				if ($i % $switch == 0) {
					echo "<div class='span2'>";
				}
				$i++;

				$t = $r;
				if ($k > 11 and $r != 'All' and $r != 'Earlier') {
					$t .= ' - ' . ($range[$k-1]-1);
				}
			?>
			<label class="checkbox">
				<input type="checkbox" value="<?php echo $r; ?>" class="by_year"> <?php echo $t; ?>
			</label>
			<?php 
			if ($i % $switch == 0 or $i == count($range)) {
				echo "</div>";
			}
			endforeach; ?>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<?php
	$per_row = ceil($count) / 2;
	$i = 0;

	foreach($movies as $m): 
		if ($i % $per_row == 0) {
			echo "<div class='span6'>";
		}
		$i++;
		$letter = substr($m->title, 0, 1);
		is_numeric($letter) and $letter = 'number';
		$released = $m->released;
		foreach($range as $k => $r)
		{
			if ($r <= $released)
			{
				$released = $r;
				break;
			}
		}
		if ($released == 'All')
		{
			end($range);
			$released = prev($range);
		}
	?>
	<label class="checkbox">
		<input type="checkbox" class="cb_movie" 
		       name="movie[]"
		       value="<?php echo $m->id; ?>" 
		       year="<?php echo $released; ?>"
		       letter="<?php echo $letter; ?>"> <?php echo "{$m->title} ({$m->released})"; ?>
	</label>
	<?php 
	if ($i % $per_row == 0 or $i == $count) {
		echo "</div>";
	}
	endforeach;
	?>
</div>
<?php
echo Form::close();
if (isset($result))
{
	echo '<hr>';
	echo $result;
}
?>
<script type="text/javascript">
	$.fn.toggleCheckbox = function() {
		this.prop('checked', !this.prop('checked'));
	}

	$(document).ready(function() {
		$('.by_letter').change(function() {
			var letter = $(this).val();
			var $boxes;
			if (letter == 'All')
			{
				$boxes = $('input[type="checkbox"]');
			}
			else if (letter == '#')
			{
				$boxes = $('input[letter="number"]');
			}
			else
			{
				$boxes = $('input[letter="'+letter+'"]');
			}
			
			$boxes.toggleCheckbox();
		});
		
		
		$('.by_year').change(function() {
			var year = $(this).val();
			var $boxes;
			console.log(year);
			if (year == 'All')
			{
				$boxes = $('input[type="checkbox"]');
			}
			else
			{
				$boxes = $('input[year="'+year+'"]');
			}
			
			$boxes.toggleCheckbox();
		});
	});
</script>