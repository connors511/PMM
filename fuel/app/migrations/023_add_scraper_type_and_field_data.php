<?php

namespace Fuel\Migrations;

class Add_scraper_type_and_field_data
{

	protected $fields = array(
	    // Movie
	    'movies' => array(
		'title',
		'originaltitle',
		'released',
		'rating',
		'directors',
		'plot',
		'plotsummary',
		'contentrating',
		'country',
		'genres',
		'tagline',
		'top250',
		'studio',
		'votes',
		'releasedate',
		'runtime',
		'producers',
		'actors',
		'mpaa',
		'writers',
		'poster',
		'imdbid',
	    ),
	    // TV
	    'tv' => array(
		'season',
		'episode',
	    ),
	    // People
	    'people' => array(
		'name',
		'biography',
		'birthname',
		'birthday',
		'birthlocation',
		'height',
	    )
	);

	public function up()
	{
		list($id, $affected) = \DB::insert('scraper_types')->columns(array(
			    'type'
			))->values(array(
			    'movies'
			))->values(array(
			    'tv'
			))->values(array(
			    'people'
			))->execute();

		foreach ($this->fields as $area => $fields)
		{
			foreach ($fields as $field)
			{
				\DB::insert('scraper_fields')->columns(array(
				    'field',
				    'scraper_type_id'
				))->values(array(
				    $field, $id
				))->execute();
			}
			$id++;
		}
	}

	public function down()
	{
		\DB::delete('scraper_types')
			->where('type', 'IN', array(
			    'tv',
			    'movies',
			    'people'
			))
			->execute();

		// Probably should check for scraper_type_id too..
		$fields = array_merge($this->fields['movies'], $this->fields['tv'],$this->fields['people']);
		\DB::delete('scraper_fields')->where('field', 'IN', $fields)->execute();
	}

}