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
	    'pmm/pmm.popover.js',
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
		?>
	<div id="movies">
		<?php
		echo render('home/overview', array('movies' => $movies));
		?>
			<script type="text/javascript">
	$(document).ready(function() {
		/*
		$('.movie').click(function() {
			var baseuri = '<?php echo Uri::create('home/watch/'); ?>';
			var uri = baseuri + $(this).attr('data-id');
			$('#container').remove();
			$.ajax({
				type: "GET", 
				timeout: 15000,
				url: uri,
				success: function(m) 
				{
					$('#movies').append(m);
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					cLog("An error occured during getMovie AJAX request. Unbinding infinite scrolling to prevent unexpected behavior");
					cLog("AJAX error was: " + textStatus);
					cLog(jqXHR);
				}
			});
		});
		$('.movie_close, #back').live('click', function() {
			$('#container').remove();
		});*/
		/*var options = {
			'placement': 'left'
		}
		$('.movie:nth-child('+count+'n):nth-child('+count+'n+1)').popover(options);*/
	});
	</script>

    <div id="movies_space"></div>
    <div id="ruler" class="movie"><div class="title"></div></div>
</div>
<div id="menu" state="closed">
	<div id="quick_search">
                <?php echo Asset::img('logo.png', array('id' => 'logo')); ?>
		<form id="quick_search_form">
			<input type="text" id="quick_search_input" value="<?php echo isset($term) ? $term : 'quick search'; ?>" />
		</form>
	</div>
	<div id="advanced_search">
		<table>
			<tr>
				<td>
					imdb rated
					<table>
						<tr>
							<td>
                                                                <div class="setting-none">
                                                                        <div class="ticbox" target="s_imdb_rating"></div>
                                                                        <span class="label_text">over</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_imdb_rating"></div>
                                                                        <span class="label_text">under</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_imdb_rating"></div>
                                                                        <span class="label_text">equal</span>
                                                                </div>
							</td>
							<input type="hidden" id="s_imdb_rating" value="0" />
						</tr>
						<tr>
							<td colspan="3" align="center">
								<?php
									for($i = 0; $i < 9; $i++)
									{
										echo '<img src="http://remarkableinnovation.com/imgs/star.png" width="16px" height="16px" />';
									}
								?>
							</td>
							<input type="hidden" id="s_imdb_rating_v" value="0" />
						</tr>
					</table>
				</td>
				<td>
					resolution
					<table>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_resolution" id="s_resolution_1080p"></div>
                                                                        <span class="label_text">1080p</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_resolution" id="s_resolution_720p"></div>
                                                                        <span class="label_text">720p</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_resolution" id="s_resolution_DVD"></div>
                                                                        <span class="label_text">DVD</span>
                                                                </div>
							</td>
						</tr>
						<input type="hidden" id="s_resolution" value="<?php echo isset($params['resolution']) ? $params['resolution'] : 0; ?>" />
					</table>
				</td>
				<td>file size</td>
				<td>
					search titles
					<table>
						<tr>
							<td>
								<input type="text" id="search_titles_input" value="<?php echo isset($params['term']) ? $params['term'] : 'Search title'; ?>">
							</td>
						</tr>
					</table>
				</td>
				<td>
					search people
					<table>
						<tr>
							<td>
								<input type="text" id="search_people_input" value="<?php echo isset($params['actors']) ? $params['actors'] : 'Search people'; ?>">
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_same_movie"></div>
                                                                        <span class="label_text">Same movie</span>
                                                                </div>
								<input type="hidden" id="s_same_movie" value="0" />
							</td>
						</tr>
					</table>
				</td>
				<td rowspan="2" valign="top">
					released
					<table>
					<?php
					$years = array('2011','2010','2009','00s','90s','80s','70s','< 70s');
					foreach($years as $y)
					{
						?>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_released" id="s_released_<?php echo $y;?>"></div>
                                                                        <span class="label_text"><?php echo $y; ?></span>
                                                                </div>
							</td>
						</tr>
						<?php
					}
					?>
					<input type="hidden" id="s_released" value="<?php echo isset($params['released']) ? str_replace('pre70s', '< 70s', $params['released']) : 0; ?>" />
					</table>
				</td>
				<td rowspan="2">
					movie genre
					<table>
					<?php
					$genres = array('drama','family','fantasy','mystery','musical','romance','thriller','Sci-Fi','animation','action','western','adult','adventure','music','short','history','horror','disaster','war','sport','Film-Noir','biography','documentary','crime','comedy','Reality-TV');
					asort($genres);
					for($i = 0; $i < count($genres); $i++)
					{
						if($i % 3 == 0) echo '<tr>';
						?>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_genres" id="s_genres_<?php echo $genres[$i];?>"></div>
                                                                        <span class="label_text"><?php echo $genres[$i]; ?></span>
                                                                </div>
							</td>
						<?php
						if($i % 3 == 2) echo '</tr>';
					}
					?>
					<input type="hidden" id="s_genres" value="<?php echo isset($params['genres']) ? $params['genres'] : 0; ?>" />
					</table>
				</td>
				<td rowspan="2">
					added
					<table>
					<?php
					$years = array('14d'=>'14 days', '1m'=>'1 month','2m'=>'2 months','6m'=>'6 months','1y'=>'1 year','g1y'=>'> 1 year');
					foreach($years as $i=>$y)
					{
						?>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_added" id="s_added_<?php echo $y;?>"></div>
                                                                        <span class="label_text" value="<?php echo $i; ?>"><?php echo $y; ?></span>
                                                                </div>
							</td>
						</tr>
						<?php
					}
					?>
					<input type="hidden" id="s_added" value="<?php echo isset($params['added']) ? str_replace('post1year', '> 1 year', $params['added']) : 0; ?>" />
					</table>
				</td>
			</tr>
			<tr>
				<td>length</td>
				<td>
					aspect ratio
					<table>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_4:3"></div>
                                                                        <span class="label_text">4:3</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_1.85:1"></div>
                                                                        <span class="label_text">1.85:1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_3:2"></div>
                                                                        <span class="label_text">3:2</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_2.39:1"></div>
                                                                        <span class="label_text">2.39:1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_16:9"></div>
                                                                        <span class="label_text">16:9</span>
                                                                </div>
							</td>
						</tr>
					<input type="hidden" id="s_aspect" value="<?php echo isset($params['aspect']) ? $params['aspect'] : 0; ?>" />
					</table>
				</td>
				<td>
					audio
					<table>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_mono"></div>
                                                                        <span class="label_text">mono</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_stereo"></div>
                                                                        <span class="label_text">stereo</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_5.1"></div>
                                                                        <span class="label_text">5.1</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_7.1"></div>
                                                                        <span class="label_text">7.1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_DTS"></div>
                                                                        <span class="label_text">DTS</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_DTS-MA"></div>
                                                                        <span class="label_text">DTS-MA</span>
                                                                </div>
							</td>
						</tr>
					<input type="hidden" id="s_audio" value="<?php echo isset($params['audio']) ? $params['audio'] : 0; ?>" />
					</table>
				</td>
				<td>search history</td>
				<td>search history</td>
			</tr>
		</table>
	</div>
</div>
<script>
d = document.getElementById('movies');
xx = Math.floor(window.width / 203);
d.style.width=(203 * xx)+"px";
PMM.Settings.BASE_URL = '<?php echo Uri::create('/'); ?>';
PMM.Init();
if (PMM.Movies != null)
	PMM.Movies._page = <?php echo \Pagination::$current_page; ?>;
</script>
<?php
	} else if (isset($movie))
	{
		echo render('home/watch', array('movie' => $movie));
	}
	?>

</body>
</html>