<?php

class MissingScraperGroupException extends Exception { }

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
	    ),
	    'sources'
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

	public static function parse_movie(Model_Movie &$movie, $allow_overwrite = false)
	{
		$scrapers = array();
		$group = $movie->file->source->scraper_group;
		if (empty($group))
		{
			throw new MissingScraperGroupException("No scraper group found for source '{$movie->file->source->path}'");
		}
		
		$scrapers = array();
		foreach($group->scraper_group_fields as $f)
		{
			$scrapers[$f->scraper->id][] = $f;
		}
		
		foreach($scrapers as $id => $sgfs)
		{
			$fields = array();
			foreach($sgfs as $sgf)
			{
				$fields[] = $sgf->scraper_field;
			}
			$scrapername = '\\'.$sgfs[0]->scraper->class;
			$scraper = new $scrapername();
			$scraper->set_movie($movie)
				->set_scrape_fields($fields)
				->set_allow_overwrite($allow_overwrite)
				->scrape();
		}
	}

}
