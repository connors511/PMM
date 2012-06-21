<a name="movies_<?php echo \Pagination::$current_page; ?>" id="movies_<?php echo \Pagination::$current_page; ?>"></a>
<?php
$i = 0;
foreach($movies as $movie)
{
    echo render('home/movie', array('movie' => $movie));
}
?>

<div class="bc-results"><span class="left">
<a href="javascript:void(0);" class="grey" onclick="Gamma.Movies.Permalink('+Gamma.Movies._page+');">Permalink</a></span>
<span style="line-height:2em;font-size:16px" class="grey">Page <strong class="white">
<?php echo \Pagination::$current_page; ?></strong> of <strong class="white"><?php echo ceil(\Pagination::total_items() / \Pagination::$per_page); ?>
</strong> from <strong class="white" style="font-family:Georgia">
	<?php echo (\Pagination::$per_page * (\Pagination::$current_page - 1) + 1) . ' - ' . (\Pagination::$per_page * (\Pagination::$current_page - 1) + $count); ?></strong>
 of <strong class="white" style="font-family:Georgia"><?php echo \Pagination::total_items(); ?></strong></span>
<span class="right" style="margin:10px 10px 0 0">
<a href="javascript:void(0);" class="grey" onclick="$.scrollTo({top: \'0px\', left: \'0px\'},800)">
&#94; Back to TOP</a></span></div>

<script type="text/javascript">
$(document).ready(function() {
	var dim = Gamma.Movies._getMovieListDimensions();
	var count = Math.floor($('#movies').outerWidth() / dim.width);

	$('.movie').popover({
		placement: function(pop, dom_el) {
			left_pos = $(dom_el).offset().left + $(dom_el).width();
			width = window.innerWidth;
			console.log(left_pos+' vs '+width);
			if (width - left_pos < 300)
				return 'left';
			return 'right';
		},
		delay: {
			show: 500,
			hide: 100
		},
		content: function(dom_el) {
			return $(this).attr('data-content-body').replace(/<b>/g,'<b class="orange">');
		}
	});
	/*var options = {
		'placement': 'left'
	}
	$('.movie:nth-child('+count+'n):nth-child('+count+'n+1)').popover(options);*/
});
</script>