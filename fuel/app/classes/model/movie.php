<?php

class Model_Movie extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'title',
	    'plot',
	    'plotsummary',
	    'tagline',
	    'rating',
	    'votes',
	    'released',
	    'runtime',
	    'runtime_file',
	    'contentrating',
	    'originaltitle',
	    'trailer_url',
	    'created_at',
	    'updated_at',
	    'file_id',
	    'poster_id'
	);
	protected static $_has_one = array(
	    'stream_video'
	);
	protected static $_has_many = array(
	    'actors',
	    'directors',
	    'producers',
	    'subtitles',
	    'fanart' => array(
			'key_from' => 'id',
	        'model_to' => 'Model_Image',
	        'key_to' => 'movie_id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	        'conditions' => array(
	        	'where' => array(
	        		array('type', '=', Model_Image::TYPE_FANART)
	        	)
	        )
	    ),
	    'stream_audios',
	    'web_images'
	);
	protected static $_belongs_to = array(
	    'file',
	    'poster' => array(
			'key_from' => 'poster_id',
	        'model_to' => 'Model_Image',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	        'conditions' => array(
	        	'where' => array(
	        		array('type', '=', Model_Image::TYPE_POSTER)
	        	)
	        )
	    ),
	);
	protected static $_many_many = array(
	    'genres'
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
	    'Observer_Streamdetails' => array(
		'events' => array('before_insert')
	    ),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('plot', 'Plot', 'required');
		$val->add_field('plotsummary', 'Plotsummary', 'required|max_length[255]');
		$val->add_field('tagline', 'Tagline', 'required|max_length[255]');
		$val->add_field('imdb_rating', 'Imdb Rating', 'required');
		$val->add_field('imdb_votes', 'Imdb Votes', 'required|valid_string[numeric]');
		$val->add_field('released', 'Released', 'required|valid_string[numeric]');
		$val->add_field('runtime', 'Runtime', 'required|valid_string[numeric]');
		$val->add_field('runtime_file', 'Runtime File', 'required|valid_string[numeric]');
		$val->add_field('contentrating', 'Contentrating', 'required|max_length[255]');
		$val->add_field('originaltitle', 'Originaltitle', 'required|max_length[255]');
		$val->add_field('poster', 'Poster', 'valid_string');
		$val->add_field('file_id', 'File', 'required|valid_string[numeric]');
		//$val->add_field('trailer_url', 'Trailer Url', 'required');

		return $val;
	}

	/**
	 * Rename all files related to the movie
	 * 
	 * @param type $pattern pattern or text to rename to
	 */
	public function rename($pattern)
	{
		$res = $this->file->resolve_path($pattern);
		$test = array();

		// Only a file rename
		// Subtitles, poster, folder art and main fanart
		$paths = array(
			/* $this->fanart,
				$this->poster */
		);
		foreach ($this->images as $img)
		{
			$paths[] = $img->file->path;
		}

		foreach ($paths as $path)
		{
			$new_path = str_replace($this->file->folder(), dirname($res), $path);
			if ($path != $new_path)
			{
				// TODO: Error handling
				rename($path, $new_path);
			}
		}
	}
	
	public function save_nfo($path)
	{
		$path = $this->file->resolve_path($path);
		$folder = dirname($path);
		$file = basename($path);
		return Model_Io_Factory::export_nfo($this, $folder, $file);
	}
	
	public function save_poster($path)
	{
		if (empty($this->poster) or $this->poster == null)
			return false;
		
		$path = $this->file->resolve_path($path);
		return copy($this->poster, $path);
	}

}
