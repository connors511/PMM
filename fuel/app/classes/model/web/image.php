<?php

class Model_Web_Image extends \Orm\Model
{
	const SOURCE_MOVIE		= 1;
	const SOURCE_PERSON		= 2;

	protected static $_properties = array(
		'id',
		'url',
		'movie_id',
		'type',
		'height',
		'width',
		'source',
		'data',
		'created_at',
		'updated_at',
		'image_id'
	);

	protected static $_belongs_to = array(
		'movie',
		'image'
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
	    'Observer_Webimage' => array(
			'events' => array('before_insert')
	    ),
	);
}
