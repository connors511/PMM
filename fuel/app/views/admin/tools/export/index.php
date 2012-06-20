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
		<span class="btn btn-success">Export</span>
	</div>
</div>
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