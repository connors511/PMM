<?php

class Model_Image extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'file_id',
	    'height',
	    'width',
	    'created_at',
	    'updated_at',
	    'movie_id',
	);
	protected static $_belongs_to = array(
	    'movie',
	    'file',
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

	public function get_thumb_url()
	{
		if (!isset($this->file_id))
		{
			return false;
		}

		// Is it already saved as a thumb?
		if ($url = Asset::find_file($this->id . '_thumb.jpg', 'img/cache'))
		{
			return $url;
		}

		$this->generate_images();
		return Asset::find_file($this->id . '_thumb.jpg', 'img/cache');
	}

	public function generate_images()
	{
		// Otherwise, create it
		Image::load(Model_File::find($this->file_id)->path)
			->save(DOCROOT . 'assets/img/cache/' . $this->id . '.jpg')
			->resize(100, 200, true)
			->save(DOCROOT . 'assets/img/cache/' . $this->id . '_thumb.jpg');
	}

}
