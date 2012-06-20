<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<?php
echo Asset::css('home.css');
Asset::js(array('jquery.min.js', 'jquery.scrollTo-1.4.2-min.js','jquery.localscroll-1.2.7-min.js','jquery.lazyload.js'), array(), 'jquery', false);
Asset::js(array('misc.js','gamma/core.js','gamma/genrescroll.js','gamma/infscroll.js','gamma/movies.js','pjax.js'), array(), 'gamma', false);
echo Asset::render('jquery');
echo Asset::render('gamma');
?>
</head>
<body>

<div id="movies">

    <?php echo render('home/overview', array('movies'=>$movies)); ?>

    <div id="movies_space"></div>
    <div id="ruler" class="movie"><div class="title"></div></div>
</div>
<div id="menu" state="closed">
	<div id="quick_search">
                <?php echo Asset::img('logo.png', array('id' => 'logo')); ?>
		<form id="quick_search_form">
			<input type="text" id="quick_search_input" value="quick search" />
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
                                                                        <span class="label">over</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_imdb_rating"></div>
                                                                        <span class="label">under</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_imdb_rating"></div>
                                                                        <span class="label">equal</span>
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
                                                                        <span class="label">1080p</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_resolution" id="s_resolution_720p"></div>
                                                                        <span class="label">720p</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_resolution" id="s_resolution_DVD"></div>
                                                                        <span class="label">DVD</span>
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
                                                                        <span class="label">Same movie</span>
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
                                                                        <span class="label"><?php echo $y; ?></span>
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
                                                                        <span class="label"><?php echo $genres[$i]; ?></span>
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
                                                                        <span class="label" value="<?php echo $i; ?>"><?php echo $y; ?></span>
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
                                                                        <span class="label">4:3</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_1.85:1"></div>
                                                                        <span class="label">1.85:1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_3:2"></div>
                                                                        <span class="label">3:2</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_2.39:1"></div>
                                                                        <span class="label">2.39:1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_aspect" id="s_aspect_16:9"></div>
                                                                        <span class="label">16:9</span>
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
                                                                        <span class="label">mono</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_stereo"></div>
                                                                        <span class="label">stereo</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_5.1"></div>
                                                                        <span class="label">5.1</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_7.1"></div>
                                                                        <span class="label">7.1</span>
                                                                </div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_DTS"></div>
                                                                        <span class="label">DTS</span>
                                                                </div>
							</td>
							<td>
								<div class="setting-none">
                                                                        <div class="ticbox" target="s_audio" id="s_audio_DTS-MA"></div>
                                                                        <span class="label">DTS-MA</span>
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
xx = Math.floor(screen.width / 203);
d.style.width=(203 * xx)+"px";
Gamma.Movies._urlBase = '<?php echo Uri::create('home/'); ?>';
Gamma.Init();
Gamma.Movies._page = <?php echo $dpage; ?>;
</script>
</body>
</html>