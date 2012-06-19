<?php
class Model_Stream_Audio extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'bitrate',
		'samplerate',
		'codec',
		'channels',
		'language',
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
		$val->add_field('bitrate', 'Bitrate', 'required|valid_string[numeric]');
		$val->add_field('samplerate', 'Samplerate', 'required|valid_string[numeric]');
		$val->add_field('codec', 'Codec', 'required|max_length[255]');
		$val->add_field('channels', 'Channels', 'required|valid_string[numeric]');
		$val->add_field('language', 'Language', 'required|max_length[255]');

		return $val;
	}

}
