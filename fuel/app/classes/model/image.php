<?php

class Model_Image extends \Orm\Model
{
	const TYPE_POSTER = 1;
	const TYPE_FANART = 2;

	protected static $_properties = array(
	    'id',
	    'file_id',
	    'height',
	    'width',
	    'created_at',
	    'updated_at',
	    'movie_id',
	    'type'
	);
	protected static $_belongs_to = array(
	    'file',
	    'movie' => array(
	        'conditions' => array(
	        	'where' => array(
	        		array('type', '=', Model_Image::TYPE_FANART)
	        	)
	   	 	)
	    )
	);
	protected static $_has_one = array(
		'poster' => array(
			'key_from' => 'id',
	        'model_to' => 'Model_Movie',
	        'key_to' => 'poster_id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	        'conditions' => array(
	        	/*'where' => array(
	        		array('type', '=', Model_Image::TYPE_POSTER)
	        	)*/
	        )
		)
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
		$val->add_field('file_id', 'File', 'required|valid_string[numeric]');
		$val->add_field('height', 'Height', 'required|valid_string[numeric]');
		$val->add_field('width', 'Width', 'required|valid_string[numeric]');
		$val->add_field('movie_id', 'Movie', 'required|valid_string[numeric]');

		return $val;
	}

	public function get_thumb_url($width = 185, $height = 265)
	{
		if (!isset($this->file_id))
		{
			return false;
		}

		// Is it already saved as a thumb?
		if (($url = \Asset::get_file($this->id . "-{$width}x{$height}.jpg", 'img','cache')))
		{
			return $url;
		}

		$this->generate_images($width, $height);
		return Asset::get_file($this->id . "-{$width}x{$height}.jpg", 'img','cache');
	}

	public function get_url()
	{
		if (!isset($this->file_id))
		{
			return false;
		}

		// Is it already saved as a thumb?
		if (($url = \Asset::get_file($this->id . '-original.jpg', 'img','cache')))
		{
			return $url;
		}

		$this->generate_images();
		return Asset::get_file($this->id . '-original.jpg', 'img','cache');
	}

	public function generate_images($width = false, $height = false)
	{
		$path = $this->file->path;
		if (!in_array($this->file->ext(), array('jpg', 'jpeg', 'png')))
		{
			$tmp = APPPATH.'tmp'.DS.\Str::random().'.jpg';
			copy($path, $tmp);
			$path = $tmp;
		}
		// Otherwise, create it
		Image::load($path);
		if ($width == false && $height == false)
		{
			Image::save(DOCROOT . 'assets/img/cache/' . $this->id . '-original.jpg');
		}
		else
		{
			Image::resize($width, $height, true)
				->save(DOCROOT . 'assets/img/cache/' . $this->id . "-{$width}x{$height}.jpg");
		}

		if ($path != $this->file->path)
		{
			// remove tmp file
			try
			{
				File::delete($path);
			}
			catch (\Exception $e)
			{}
		}
	}

	public function set_dimensions()
	{
		$path = $this->file->path;
		if (!in_array($this->file->ext(), array('jpg', 'jpeg', 'png')))
		{
			$tmp = APPPATH.'tmp'.DS.\Str::random().'.jpg';
			copy($path, $tmp);
			$path = $tmp;
		}

		try
		{
			$image = Image::load($path);
			$sizes = $image->sizes();

			$this->height = $sizes->height;
			$this->width = $sizes->width;
		}
		catch (RuntimeException $e)
		{
			// GD lib not found, so we cant get image height and width
			$this->height = 0;
			$this->width = 0;
		}
		catch (Exception $e)
		{
			continue;
		}

		if ($path != $this->file->path)
		{
			// remove tmp file
			try
			{
				File::delete($path);
			}
			catch (\Exception $e)
			{}
		}
	}

}
