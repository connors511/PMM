<?php

class Model_Web_Image extends \Orm\Model
{
	const SOURCE_MOVIE		= 1;
	const SOURCE_PERSON		= 2;

	protected static $_properties = array(
		'id',
		'url',
		'movie_id',
		'type',
		'height',
		'width',
		'source',
		'data',
		'created_at',
		'updated_at',
		'image_id'
	);

	protected static $_belongs_to = array(
		'movie',
		'image'
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	    'Observer_Webimage' => array(
			'events' => array('before_insert')
	    ),
	);

	public function download($to_movie = false, $set_as_poster = false)
	{
		$path = APPPATH . 'tmp/' . sha1($this->url) . '.jpg';
		if ($to_movie)
		{
			$path = $this->movie->file->folder() . DS . 'movie.tbn';
		}
		\Log::debug("Downloading {$this->url} to path '{$path}'");

		$page = Request::forge($this->url, array(
				    'driver' => 'curl',
				    'set_options' => array(
					//CURLOPT_FILE => $img,
					CURLOPT_HEADER => 0,
					CURLOPT_MAXREDIRS => 2,
					CURLOPT_FOLLOWLOCATION => 1,
					CURLOPT_HTTPHEADER => array(
					    "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
					    "Accept-Language: en-us,en"
				    ))
				))->execute()->response();

		if (file_exists($path))
		{
			\File::delete($path);
		}
		\File::create(dirname($path), basename($path), $page);

		$im = Model_Image::find('all', array(
			    'related' => array(
					'file' => array(
					    'where' => array(
							array(
							    'path', '=', $path
							)
					    )
					),
					'movie'
			    )
			));

		if (count($im) == 1)
		{
			$im = current($im);
		}
		else if (count($im) > 1)
		{
			// That is just fucked up
			continue;
		}

		if ($im == null || $im->movie == null)
		{
			$im = new Model_Image();
			$im->file = new Model_File();
			$im->file->path = $path;
			$im->file->source = $this->movie->file->source;
			$im->type = $this->type;


			$im->movie = $this->movie;
		}
		try
		{
			$im->set_dimensions();
			if ($set_as_poster)
			{
				$im->poster = $this->movie;
			}
			$im->save();

			$this->image = $im;
			$this->save();
		}
		catch (\Exception $e)
		{
			
		}
		catch (\ErrorException $ee)
		{

		}

		return $im;
	}
}
