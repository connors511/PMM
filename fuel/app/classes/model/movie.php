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
	    'thumb',
	    'fanart',
	    'trailer_url',
	    'created_at',
	    'updated_at',
	    'file_id',
	    'poster'
	);
	protected static $_has_many = array(
	    'actors',
	    'directors',
	    'producers',
	    'subtitles',
	    'images',
	);
	protected static $_belongs_to = array(
	    'file',
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
		$val->add_field('thumb', 'Thumb', 'required|valid_string[numeric]');
		$val->add_field('fanart', 'Fanart', 'required|valid_string[numeric]');
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
		//$pattern = str_replace('$','$this->',$pattern);
		extract($this->_data);
		$pattern = preg_replace('#\$((\w|->|_|\((true|false)*\))+)#', "'.\$this->$1.'", $pattern);
		$pattern .= "'";
		if (substr($pattern, 0, 2) == "'.")
		{
			$pattern = substr($pattern, 2);
		}
		else
		{
			$pattern = "'" . $pattern;
		}
		//echo $pattern . '<br>';
		eval('$res = ' . $pattern . ';');
		
		if (strpos($res, '/') === false)
		{
			// Only a file rename
			// Subtitles, poster, folder art and main fanart
			$paths = array(
				/* $this->thumb,
				  $this->fanart,
				  $this->poster */
			);
			foreach ($this->images as $img)
			{
				$paths[] = $img->file->path;
			}
			
			foreach ($paths as $path)
			{
				
				// Construct new file name
			}

			/*if (rename($this->file->path, $res))
			{
				// Rename success
			}
			else
			{
				
			}*/
		}
		else
		{
			
		}
		die();
	}

}
