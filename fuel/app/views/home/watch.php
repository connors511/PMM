<style>
/*	html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {
border: 0px;
font-family: inherit;
font-size: 100%;
font-style: inherit;
font-weight: inherit;
margin: 0px;
outline: 0px;
padding: 0px;
vertical-align: baseline;
}*/
body {
	padding: 0;
	margin: 0;
	color: white;
}
* {
	border: none;
	outline: none;
}
table {
	border-collapse: separate;
	border-spacing: 0;
	}
caption, th, td {
	text-align: left;
	font-weight: normal;
	}

/*  About
---------------------------------------*/

a {
	color:white;
}
a
#backdrop {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 300px;
	overflow: hidden;
}

#backdrop, #backdrop img {
}

/* Movie page */
#movie {
	margin: 0 auto;
	position: relative;
	width: 900px;
}
#container {
	top: 52px;
}
#container {
	left: 0px;
	position: absolute;
	top: 52px;
	width: 100%;
	z-index: 30;
}
#about {
	position: absolute;
	top: 0;
	left: 185px;
	z-index: 10;

	min-height: 200px;
	/* fallback*/
	background: rgb(23, 23, 23);
	background: rgba(23, 23, 23, 0.9);
	width: 555px;
	
	border-radius: 0 0 20px 20px;
	-moz-border-radius: 0 0 20px 20px;
	-webkit-border-radius: 0 0 20px 20px;

	-webkit-border-top-left-radius: 0;
	-webkit-border-top-right-radius: 0;
	-webkit-border-bottom-right-radius: 20px;
	-webkit-border-bottom-left-radius: 20px;
	
	font-family: Helvetica, Arial, sans-serf;
	font-size: 13px;
}

#title, #meta, #people, h1.title {
	border-bottom: 1px solid #333;
}
#title, h1.title {
	vertical-align: middle;
	font-size: 20px;
	font-weight: bold;
	line-height: 23px;
	padding: 10px 115px 10px 15px;
}

#title span, h1.title span {
	color: #888;
	font-weight: normal;
}

#meta, #director, #cast, #ratings, #tech div {
	color: #aaa;
	padding: 0 15px;
	border-bottom: 1px solid #333;
	overflow: hidden;
	line-height: 23px;
}



#meta a, #director a, #cast a, #tech div a {
	color: #aaa;
	text-decoration: none;
}

#meta a:hover, #director a:hover, #cast a:hover, #tech div a:hover {
	color: #fff;
	text-decoration: underline;
}

#director strong, #cast strong, #ratings strong, #ratings em, .rating strong, .rating em, #tech div strong {
	color: #666;
}

#cast td {
	white-space: auto;
	line-height: 18px;
	padding-bottom: 2px;
}

#meta span, #ratings span, #tech div span {
	display: block;
	float: left;
	padding: 0 8px 0 0;
	margin: 0 8px 0 0;
	border-right: 1px solid #333;
}
#meta span:last-child, #ratings span:last-child, #tech div span:last-child {
	border: 0;
	margin: 0;
	padding: 0;
}
#synopsis, #trailer {
	padding: 10px 15px;
	line-height: 18px;
	color: #ccc;
}

/*  Backdrop
----------------------------------------*/

#play_movie, #back, #view_comments {
	display: block;
	text-align: center;
	text-decoration: none;
	margin: 0 0 4px 0;
	color: #000;
	background: transparent url(<?php echo Asset::get_file('buttons.png','img'); ?>) 0 0 no-repeat;
	font-weight: bold;
}

#play_movie, #back, #view_comments {
	text-shadow: #fff 0 1px 0;
	position: relative;
	font-size: 26px;
	line-height: 51px;
	width: 105px;
	padding-right: 15px;
	left: 2px;
	background-position: -144px 0;
}

#back {
	position: absolute;
	left: -28px;
	width: 25px;
	text-indent: -3000px;
	background-position: -114px 0;
	padding: 0;
}

#play_movie:hover, #play_movie:active, #view_comments:hover, #view_comments:active {
	background-position: -144px -60px;
}

#back:hover, #back:active {
	background-position: -114px -60px;
}
#play_button {
	position: absolute;
	right: 0;
	top: 0;
	left: 741px;
	width: 120px;
	font-size: 15px;
	z-index: 20;
}
#view_comments {
	font-size: 14px;	
}

</style>    

<div id="container">
	<?php if(!isset($error)) { ?>
        <div id="movie">
        	<a href="javascript:void(0)" id="back">Back</a> 
            <img alt="The-expendables-cover" id="poster" src="<?php echo str_replace('w500','w185',$movie->poster); ?>" /> 
        	<div id="about"> 
            	<h1 id="title"><?php echo $movie->title; ?> <span><?php echo $movie->released; ?></span></h1>
		<a class="icon-remove icon-white movie_close" href="#" style="position: absolute; top: 5px; right: 5px;"></a>
            	<p id="meta">
                    <span id="runtime"><?php echo $movie->runtime; ?> minutes</span>
                    <span id="movie_genres">
			<?php
			$s = "";
			if(!empty($movie->genres)) {
			    foreach($movie->genres as $genre) {
				$s .= (string)'<a href="'.Uri::create('genre/'.$genre->id).'"title="'.$genre->name.' movies">'.$genre->name.'</a>, '; 
			    }
			    echo substr($s, 0, -2);
			} else {
			    echo 'Unknown';
			}
			?>
                    </span>
                    <span class="rating" id="imdb_rating"><strong>Rating:</strong> <?php echo number_format($movie->rating,1); ?><em> / 10</em></span>
		</p> 
                <div id="tech">
                	<div id="tech_display">
                        <span id="tech_type"><strong>Type:</strong> 
			<?php if($movie->stream_video->width == 1920 && $movie->stream_video->height >= 1072) {
			    echo 'Full HD';
			} else if($movie->stream_video->width >= 1280 && $movie->stream_video->height > 480) {
			    echo 'HD';
			} else {
			    echo 'SD';
			}
			?></span>
                        <span id="tech_res"><strong>Resolution:</strong> <?php echo $movie->stream_video->width; ?><strong>x</strong><?php echo $movie->stream_video->height; ?></span>
                        <span id="tech_aspect"><strong>Aspect:</strong> <?php echo number_format($movie->stream_video->width / $movie->stream_video->height,2); ?></span>
                        <span id="tech_format"><strong>Format:</strong> <?php echo $movie->file->ext(); ?></span>
                    </div>
                    <div id="tech_lang">
                        <span id="tech_aud_channels"><strong>Audio Channels:</strong>
			<?php
			switch(current($movie->stream_audios)->channels) {
			    case 2:
				echo '2';
				break;
			    case 6:
				echo '5.1';
				break;
			    case 8:
				echo '7.1';
				break;
			    default:
				echo current($movie->stream_audios)->channels.' channels';
				break;
			}
			?>
			</span>
                        <span id="tech_aud_lang"><strong>Audio Language:</strong>
			<?php
			$s = "";
			foreach($movie->stream_audios as $audio) {
				$s .= $audio->language.' ('.$audio->codec.'), '; 
			}
			echo substr($s, 0, -2);
			?></span>
                    </div>
                    <div>
                        <span id="tech_sub_lang"><strong>Subtitles:</strong> 
			<?php
			$s = "";
			foreach($movie->subtitles as $sub) {
				$s .= $sub->language.', '; 
			}
			$s = substr($s, 0, -2);
			echo empty($s) ? 'None' : $s;
			?></span>
                    </div>
                </div>
            	<p id="director">
                	<strong>Director:</strong>
			<?php
			$s = array();
			foreach($movie->directors as $director) {
				$s[] = Html::anchor(Uri::create('movie/by/'.$director->id.'-'.Inflector::friendly_title($director->person->name)), $director->person->name, array(
				    'title' => "Movies directed by {$director->person->name}"
				));
			}
			$s = implode(', ',$s);
			echo empty($s) ? 'Unknown' : $s;
			?>
              	</p>						
              	<div id="cast"> 
                <table> 
                    <tr> 
                        <th><strong>Cast:</strong>&nbsp;</th> 
                        <td>
			<?php
			$s = '';
			foreach($movie->actors as $actor) {
				$s .= '<tr><td style="padding-right:20px"><a href="'.Uri::create('movie/with/'.$actor->id.'-'.Inflector::friendly_title($actor->person->name)).'"';
				$s .= ' title="Movies with '.$actor->person->name.'">'.$actor->person->name.'</a></td><td> as '.$actor->role.'</td></tr>';
			}
			$s .= '</table>';;
			echo empty($s) ? 'Unknown' : $s;
			?>
			</td>
                    </tr> 
                </table> 
            </div> 
            <div id="synopsis"> 
                <?php echo $movie->plot; ?>
	    </div>
        </div>
        <div id="play_button"> 
            <a href="<?php echo Uri::create('home/stream/'.$movie->id); ?>" id="play_movie">Play!</a> 
            <a href="/" id="view_comments">Comments</a> 
        </div> 
        </div> <!-- movie -->
	<?php } else { ?>
	<div id="error_message">
	    <?php echo $error; ?>
	</div>
	<?php } ?>
    </div> <!-- content -->
    
    <?php if(!isset($error)) { ?>
    <!--<div id="backdrop">
	<?php
	if(isset($backdrops) && !empty($backdrops)) {
	    foreach($backdrops as $i) {
		echo Asset::img($i,array('alt'=>'Backdrop'));
	    }
	}
	?>
    </div>-->
    <?php } ?>