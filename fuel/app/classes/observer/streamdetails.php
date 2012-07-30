<?php

class Observer_Streamdetails extends Orm\Observer
{

	public function before_insert(Model_Movie $model)
	{
		require_once(APPPATH . 'vendor/ffmpeg-php/FFmpegAutoloader.php');
		try
		{
			$movie = new FFmpegMovie($model->file->path/*, null, \Config::get('settings.binaries.ffmepg')*/);

			$video = new Model_Stream_Video();
			$video->duration	= $movie->getDuration();
			$video->frames		= $movie->getFrameCount();
			$video->fps		= $movie->getFrameRate();
			$video->height		= $movie->getFrameHeight();
			$video->width		= $movie->getFrameWidth();
			$video->pixelformat	= $movie->getPixelFormat();
			$video->bitrate		= $movie->getBitRate();
			$video->codec		= $movie->getVideoCodec();

			$model->stream_video	= $video;

			$bitrates	= $movie->getAudioBitRate();
			$samplerates	= $movie->getAudioSampleRate();
			$codecs		= $movie->getAudioCodec();
			$channels	= $movie->getAudioChannels();
			$langs		= $movie->getAudioLanguage();

			for($i = 0; $i < count($bitrates); $i++)
			{
				$audio = new Model_Stream_Audio();
				$audio->bitrate		= isset($bitrates[$i]) ? $bitrates[$i] : 0;
				$audio->samplerate	= isset($samplerates[$i]) ? $samplerates[$i] : 0;
				$audio->codec		= isset($codecs[$i]) ? $codecs[$i] : '';
				$audio->channels	= isset($channels[$i]) ? $channels[$i] : 0;
				$audio->language	= isset($langs[$i]) ? $langs[$i] : '';

				$model->stream_audios[] = $audio;
			}
		}
		catch(\Exception $e)
		{
			
		}
		
	}

}