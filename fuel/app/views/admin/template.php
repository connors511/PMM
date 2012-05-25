<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<title><?php echo ucwords(str_replace('_',' &raquo; ',$title)); ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<style>
	    body { margin: 50px; }
	</style>
	<?php
	echo Asset::js(array(
	    'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
	    'bootstrap.js'
	));
	?>
	<script>
	    $(function(){ $('.topbar').dropdown(); });
	</script>
    </head>
    <body>
	
	<?php if ($current_user): ?>
    	<div class="navbar navbar-fixed-top">
    	    <div class="navba">
    		<div class="navbar-inner">
    		    <div class="container">
    			<h3><a href="<?php echo Uri::create('admin'); ?>" class="brand">PMM</a></h3>
    			<div class="nav-collapse">
    			    <ul class="nav">
    				<li class="<?php echo Uri::segment(2) == '' ? 'active' : '' ?>">
					<?php echo Html::anchor('admin', '<i class="icon-home icon-white"></i> Dashboard') ?>
    				</li>
				    <?php
				    $people = array(
					'actors',
					'directors',
					'producers'
				    );
				    $files = array(
					'images',
					'movies',
					'subtitles'
				    );
				    $scrapers = array(
					'types',
					'fields',
					'groups'
				    );
				    $dropdowns = array('people','files','scrapers');
				    ?>

    				<li class="dropdown">
    				    <a href="" class="dropdown-toggle" data-toggle="dropdown">People <b class="caret"></b></a>
    				    <ul class="dropdown-menu">
    					<li class="<?php echo Uri::segment(2) == 'people' ? 'active' : '' ?>">
						<?php echo Html::anchor('admin/people', 'People'); ?>
    					</li>
    					<li class="divider"></li>
					    <?php foreach ($people as $controller): ?>

						<?php
						$section_segment = basename($controller, '.php');
						$section_title = Inflector::humanize($section_segment);
						?>

						<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
						    <?php echo Html::anchor('admin/' . $section_segment, $section_title) ?>
						</li>
					    <?php endforeach; ?>
    				    </ul>
    				</li>
    				<li class="dropdown">
    				    <a href="" class="dropdown-toggle" data-toggle="dropdown">Files <b class="caret"></b></a>
    				    <ul class="dropdown-menu">
    					<li class="<?php echo Uri::segment(2) == 'files' ? 'active' : '' ?>">
						<?php echo Html::anchor('admin/files', 'Files'); ?>
    					</li>
    					<li class="divider"></li>
					    <?php foreach ($files as $controller): ?>

						<?php
						$section_segment = basename($controller, '.php');
						$section_title = Inflector::humanize($section_segment);
						?>

						<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
						    <?php echo Html::anchor('admin/' . $section_segment, $section_title) ?>
						</li>
					    <?php endforeach; ?>
    				    </ul>
    				</li>

				    <?php foreach (glob(APPPATH . 'classes/controller/admin/*.php') as $controller): ?>

					<?php
					$section_segment = basename($controller, '.php');
					if (in_array($section_segment, $people)
						or in_array($section_segment, $files)
						or in_array($section_segment, $dropdowns))
					{
					    continue;
					}
					$section_title = Inflector::humanize($section_segment);
					?>

					<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
					    <?php echo Html::anchor('admin/' . $section_segment, $section_title) ?>
					</li>
				    <?php endforeach; ?>
    				<li class="dropdown">
    				    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Scrapergroup <b class="caret"></b></a>
    				    <ul class="dropdown-menu">
					    <?php foreach (glob(APPPATH . 'classes/controller/admin/scrapergroup/*.php') as $controller): ?>

						<?php
						$section_segment = basename($controller, '.php');
						$section_title = Inflector::humanize($section_segment);
						?>

						<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
						    <?php echo Html::anchor('admin/scrapergroup/' . $section_segment, $section_title) ?>
						</li>
					    <?php endforeach; ?>
    				    </ul>
    				</li>
				<li class="dropdown">
    				    <a href="" class="dropdown-toggle" data-toggle="dropdown">Scrapers <b class="caret"></b></a>
    				    <ul class="dropdown-menu">
    					<li class="<?php echo Uri::segment(2) == 'scrapers' ? 'active' : '' ?>">
						<?php echo Html::anchor('admin/scrapers', 'Scrapers'); ?>
    					</li>
    					<li class="divider"></li>
					    <?php foreach ($scrapers as $controller): ?>

						<?php
						$section_segment = basename($controller, '.php');
						$section_title = Inflector::humanize($section_segment);
						?>

						<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
						    <?php echo Html::anchor('admin/scraper/' . $section_segment, $section_title) ?>
						</li>
					    <?php endforeach; ?>
    				    </ul>
    				</li>
    			    </ul>
    			    <!-- User menu -->
    			    <ul class="nav pull-right">
    				<li class="dropdown">
    				    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $current_user->username; ?> <b class="caret"></b></a>
    				    <ul class="dropdown-menu">
    					<li><?php echo Html::anchor('admin/logout', 'Logout') ?></li>
    				    </ul>
    				</li>
    			    </ul>
    			</div>
    		    </div>
    		</div>
    	    </div>
    	</div>
	<?php endif; ?>

	<div class="container">
	    <div class="row">
		<div class="span12">
		    <h1><?php echo ucwords(str_replace('_',' &raquo; ',$title)); ?></h1>
		    <hr>
		    <?php if (Session::get_flash('success')): ?>
    		    <div class="alert alert-success">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
    			<?php echo implode('', e((array) Session::get_flash('success'))); ?>
    		    </div>
		    <?php endif; ?>
		    <?php if (Session::get_flash('error')): ?>
    		    <div class="alert alert-error">
			    <a class="close" data-dismiss="alert" href="#">&times;</a>
			    <?php echo implode('', (array) Session::get_flash('error')); ?>
    		    </div>
		    <?php endif; ?>
		</div>
		<div class="span12">
		    <?php echo $content; ?>
		</div>
	    </div>
	    <footer>
		<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
		<p>
		    <a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
		    <small>Version: <?php echo e(Fuel::VERSION); ?></small>
		</p>
	    </footer>
	</div>
    </body>
</html>
