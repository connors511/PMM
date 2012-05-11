<?php

class Model_Actor extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'person_id',
	    'movie_id',
	    'role',
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
		$val->add_field('person', 'Person', 'required|valid_string[numeric]');
		$val->add_field('movie', 'Movie', 'required|valid_string[numeric]');
		$val->add_field('role', 'Role', 'required|max_length[255]');

		return $val;
	}

}