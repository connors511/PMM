<?php

class Model_Person extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'name',
	    'biography',
	    'birthname',
	    'birthday',
	    'birthlocation',
	    'height',
	    'created_at',
	    'updated_at',
	);
	protected static $_has_many = array(
	    'actors',
	    'directors',
	    'producers',
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
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('biography', 'Biography', 'required');
		$val->add_field('birthname', 'Birthname', 'required|max_length[255]');
		$val->add_field('birthday', 'Birthday', 'required|valid_string[numeric]');
		$val->add_field('birthlocation', 'Birthlocation', 'required|max_length[255]');
		$val->add_field('height', 'Height', 'required|valid_string[numeric]');

		return $val;
	}

}
