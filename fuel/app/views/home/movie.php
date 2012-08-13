<div class="movie" rel="popover" data-content-body="<?php include('popover.php'); ?>" data-original-title="<?php echo $movie->title; ?>" data-id="<?php echo $movie->id; ?>">
        <div class="title orange"><?php echo $movie->title; ?></div>
        <div class="cover">
                <img src="<?php echo $movie->poster == null ? "http://placehold.it/185x265" : $movie->poster->get_thumb_url(); ?>" />
                <div class="bar">
                        <span class="year"><?php echo $movie->released; ?></span>
                        <?php
                        if($movie->stream_video && $movie->stream_video->width == 1920 && ($movie->stream_video->height >= 1072)) {
				echo '<span class="hd full">Full HD</span>';
                        } elseif($movie->stream_video && $movie->stream_video->width >= 1280 && ($movie->stream_video->height > 480)) {
				echo '<span class="hd">720 HD</span>';
                        } else {
				echo '<span class="sd hd">480 SD</span>';
                        }
                        ?>
                </div>
        </div>
</div>