<?php

class Model_Scraper_Group extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'name',
	    'scraper_type_id',
	    'comment',
	    'created_at',
	    'updated_at',
	);
	protected static $_has_many = array(
	    'scraper_group_fields' => array(
		'cascade_delete' => true
	    )
	);
	protected static $_belongs_to = array(
	    'scraper_type'
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
		$val->add_field('scraper_type_id', 'Scraper Type Id', 'required|valid_string[numeric]');
		$val->add_field('comment', 'Comment', 'valid_string');

		return $val;
	}

	public static function parse_movie(Model_Movie $movie, $all_fields = true)
	{
		$scrapers = array();
		$group = $movie->file->source->scrapergroup;
		foreach ($movie->properties() as $prop => $val)
		{
			$scraper_name = Model_Scraper::find($group->{$prop}->id);
			if ($scraper_name == null)
			{
				// Oh snap!
				continue;
			}
			Debug::dump($scraper_name);
			$class = $scaper_name->class;
			echo $class;
			die();
			$scraper = new $class();
			$scraper->set_movie($movie);
			$scraper->search_imdb($all_fields);
		}
	}

}
