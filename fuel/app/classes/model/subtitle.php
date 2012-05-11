<?php

class Model_Subtitle extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'file_id',
	    'language',
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
		$val->add_field('language', 'Language', 'required|max_length[255]');
		$val->add_field('movie_id', 'Movie', 'required|valid_string[numeric]');

		return $val;
	}

}
