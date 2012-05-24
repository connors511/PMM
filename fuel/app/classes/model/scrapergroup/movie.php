<?php

class Model_Scrapergroup_Movie extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'name',
	    'title',
	    'plot',
	    'plotsummary',
	    'tagline',
	    'rating',
	    'votes',
	    'released',
	    'runtime',
	    'contentrating',
	    'originaltitle',
	    'trailer_url',
	    'created_at',
	    'updated_at',
	);
	protected static $_has_many = array(
	    'scrapers'
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
		$val->add_field('title', 'Title', 'required|valid_string[numeric]');
		$val->add_field('plot', 'Plot', 'required|valid_string[numeric]');
		$val->add_field('plotsummary', 'Plotsummary', 'required|valid_string[numeric]');
		$val->add_field('tagline', 'Tagline', 'required|valid_string[numeric]');
		$val->add_field('rating', 'Rating', 'required|valid_string[numeric]');
		$val->add_field('votes', 'Votes', 'required|valid_string[numeric]');
		$val->add_field('released', 'Released', 'required|valid_string[numeric]');
		$val->add_field('runtime', 'Runtime', 'required|valid_string[numeric]');
		$val->add_field('contentrating', 'Contentrating', 'required|valid_string[numeric]');
		$val->add_field('originaltitle', 'Originaltitle', 'required|valid_string[numeric]');
		$val->add_field('trailer_url', 'Trailer Url', 'required|valid_string[numeric]');

		return $val;
	}

	public static function parse_movie(Model_Movie $movie, $all_fields = true)
	{
		$scrapers = array();
		$group = $movie->file->source->scrapergroup;
		foreach ($movie->properties() as $prop => $val)
		{
			$scraper_name = Model_Scraper::find($group->{$prop}->id);
			if ($scraper_name == null) {
				// Oh snap!
				continue;
			}
			Debug::dump($scraper_name);
			$class = $scaper_name->class;
			echo $class;die();
			$scraper = new $class();
			$scraper->set_movie($movie);
			$scraper->search_imdb($all_fields);
		}
	}

}
