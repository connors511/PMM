<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<?php
echo Asset::css('bootstrap.css');
echo Asset::css('bootstrap-responsive.css');
echo Asset::css('home.css');
Asset::js(array('jquery-1.7.2.js', 'jquery.scrollTo-1.4.2-min.js','jquery.localscroll-1.2.7-min.js','jquery.lazyload.js','jquery.hoverIntent.js'), array(), 'jquery', false);
//Asset::js(array('misc.js','gamma/core.js','gamma/genrescroll.js','gamma/infscroll.js','gamma/movies.js','pjax.js'), array(), 'gamma', false);
Asset::js(
	array(
	    'misc.js',
	    'pmm/pmm.js',
	    'pmm/pmm.settings.js',
	    'pmm/pmm.lang.js',
	    'pmm/pmm.search.js', 
	    'pmm/pmm.movies.js', 
	    //'pmm/pmm.search.advanced.js',
	    'pmm/pmm.infinitescrolling.js',
	    'pjax.js'), 
	array(), 'gamma', false);
echo Asset::render('jquery');
echo Asset::js('bootstrap.js');
echo Asset::render('gamma');
?>
</head>
<body>

	<?php
	if (isset($movies))
	{
		echo render('home/overview', array('movies' => $movies));
	} else if (isset($movie))
	{
		echo render('home/watch', array('movie' => $movie));
	}
	?>

</body>
</html>