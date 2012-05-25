<?php
class Model_Scraper_Type extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'type',
	);
	protected static $_has_many = array(
	    'scrapers',
	    'scraper_fields',
	    'scraper_groups'
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('type', 'Type', 'required|max_length[255]');

		return $val;
	}

}
