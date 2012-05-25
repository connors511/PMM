<?php

class Model_Scraper_Group_Field extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'scraper_field_id',
	    'scraper_group_id',
	    'scraper_id',
	    'created_at',
	    'updated_at'
	);
	protected static $_belongs_to = array(
	    'scraper_group',
	    'scraper_field',
	    'scraper'
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

}
