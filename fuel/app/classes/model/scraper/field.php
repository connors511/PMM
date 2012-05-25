<?php

class Model_Scraper_Field extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'field',
	    'scraper_type_id',
	);
	protected static $_belongs_to = array(
	    'scraper_type'
	);
	protected static $_has_many = array(
	    'scraper_group_fields',
	);
	protected static $_many_many = array(
	    'scrapers'
	);
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('field', 'Field', 'required|max_length[255]');
		$val->add_field('type', 'Type', 'required|valid_string[numeric]');

		return $val;
	}

}
