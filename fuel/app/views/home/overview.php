<a name="movies_<?php echo $dpage; ?>" id="movies_<?php echo $dpage; ?>"></a>
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
<?php echo $dpage; ?></strong> of <strong class="white"><?php echo ceil($total_movies / $per_page); ?>
</strong> from <strong class="white" style="font-family:Georgia"><?php echo ($per_page * ($dpage - 1) + 1) . ' - ' . ($per_page * ($dpage - 1) + $count); ?></strong>
 of <strong class="white" style="font-family:Georgia"><?php echo $total_movies; ?></strong></span>
<span class="right" style="margin:10px 10px 0 0">
<a href="javascript:void(0);" class="grey" onclick="$.scrollTo({top: \'0px\', left: \'0px\'},800)">
&#94; Back to TOP</a></span></div>