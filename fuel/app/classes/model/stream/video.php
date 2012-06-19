<?php
class Model_Stream_Video extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'duration',
		'frames',
		'fps',
		'height',
		'width',
		'pixelformat',
		'bitrate',
		'codec',
		'movie_id',
		'created_at',
		'updated_at',
	);
	
	protected static $_belongs_to = array(
	    'movie'
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
		$val->add_field('duration', 'Duration', 'required');
		$val->add_field('frames', 'Frames', 'required|valid_string[numeric]');
		$val->add_field('fps', 'Fps', 'required');
		$val->add_field('height', 'Height', 'required|valid_string[numeric]');
		$val->add_field('width', 'Width', 'required|valid_string[numeric]');
		$val->add_field('pixelformat', 'Pixelformat', 'required|max_length[255]');
		$val->add_field('bitrate', 'Bitrate', 'required|valid_string[numeric]');
		$val->add_field('codec', 'Codec', 'required|max_length[255]');

		return $val;
	}

}
