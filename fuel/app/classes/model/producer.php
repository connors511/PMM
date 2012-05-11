<?php

class Model_Producer extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'person_id',
	    'movie_id',
	    'created_at',
	    'updated_at',
	);
	protected static $_belongs_to = array(
	    'person',
	    'movie',
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
		$val->add_field('person_id', 'Person', 'required|valid_string[numeric]');
		$val->add_field('movie_id', 'Movie', 'required|valid_string[numeric]');

		return $val;
	}

}
