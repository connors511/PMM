<?php
class Model_Scraper extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'author',
		'type',
		'version',
		'fields',
		'created_at',
		'updated_at',
		'class'
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
		$val->add_field('author', 'Author', 'required|max_length[255]');
		$val->add_field('type', 'Type', 'required|max_length[255]');
		$val->add_field('version', 'Version', 'required|max_length[255]');
		$val->add_field('fields', 'Fields', 'required');
		$val->add_field('class', 'Class', 'required|max_length[255]');

		return $val;
	}

}
