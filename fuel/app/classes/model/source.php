<?php
class Model_Source extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'path',
		'scrapergroup',
		'created_at',
		'updated_at',
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
		$val->add_field('path', 'Path', 'required');
		$val->add_field('scrapergroup', 'Scrapergroup', 'required|valid_string[numeric]');

		return $val;
	}

}
