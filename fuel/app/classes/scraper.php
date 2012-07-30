<?php

/**
 *
 * @author Matthias
 */
abstract class Scraper
{

	protected $_movie;
	protected $_id;
	protected $_overwrite;
	protected $_scrape_fields;

	public function set_movie(Model_Movie &$movie)
	{
		$this->_movie = $movie;
		return $this;
	}

	public function set_allow_overwrite($allow)
	{
		$this->_overwrite = (bool) $allow;
		return $this;
	}

	public function set_scrape_fields(Array $fields)
	{
		$this->_scrape_fields = $fields;
		return $this;
	}

	public function get_author()
	{
		return $this->_author;
	}

	public function get_name()
	{
		return $this->_name;
	}

	public function get_supported_fields()
	{
		return Model_Scraper_Field::find('all', array(
			    'where' => array(
				array('field', 'IN', $this->_fields)
			    )
			));
	}

	public function get_type()
	{
		return Model_Scraper_Type::find('first', array(
			    'where' => array(
				array('type', '=', $this->_type)
			    )
			));
	}

	public function get_version()
	{
		return $this->_version;
	}

	// Search the site for the movie ID on the site
	public abstract function search_site();

	// Do the actual scraping
	public function scrape()
	{
		Log::debug("Scraping '{$this->_movie->title}'");
		if ($this->_id == null)
		{
			$this->search_site();
		}

		if ($this->_id == '' or $this->_id == null)
		{
			// Skip if no id was found.
			return;
		}

		foreach ($this->_scrape_fields as $field)
		{
			$this->populate_field($field->field);
		}
		$this->_movie->save();
		Log::debug("Finished scraping '{$this->_movie->title}'");
	}

	// Downloads a webpage
	protected function download_url($url, $cache = true)
	{
		try
		{
			$page = Cache::get(sha1($url));
		}
		catch (\CacheNotFoundException $e)
		{
			$page = Request::forge($url, array(
				    'driver' => 'curl',
				    'set_options' => array(
					//CURLOPT_FILE => $img,
					CURLOPT_HEADER => 0,
					CURLOPT_MAXREDIRS => 2,
					CURLOPT_FOLLOWLOCATION => 1,
					CURLOPT_HTTPHEADER => array(
					    "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
					    "Accept-Language: en-us,en"
				    ))
				))->execute()->response();
			if ($cache)
			{
				Cache::set(sha1($url), $page);
			}
		}
		return $page;
	}

	protected function download_url_param($url, $param, $cache = true)
	{
		return $this->download_url(sprintf($url, $param), $cache);
	}

	public function populate_field($field)
	{
		if ($this->_overwrite or empty($this->_movie->{$field}))
		{
			Log::debug("Scraping field '{$field}'");
			$func = 'scrape_' . $field;
			$res = $this->{$func}();
			if ($res)
			{
				$this->_movie->{$field} = $res;
				$this->_movie->save();
			}
			Log::debug("Done scraping field '{$field}'");
		}
		else
		{
			Log::debug("Skipped field '{$field}'");
		}
	}

	public function get_actor($name, $role)
	{
		$person = Model_Person::find('first', array(
			    'where' => array(
				array('name', '=', $name)
			    )
			));

		if ($person == null)
		{
			$person = new Model_Person();
			$person->name = $name;
			$person->save();
		}

		$actor = Model_Actor::find('all', array(
			    'related' => array(
				'person' => array(
				    'where' => array(
					array(
					    'name', '=', $name
					)
				    )
				)
			    ),
			    'where' => array(
				array(
				    'role' => $role
				)
			    )
			));

		foreach ($actor as $a)
		{
			if ($this->_movie instanceof Model_Movie and $a->movie instanceof Model_Movie and $a->movie->id == $this->_movie->id)
			{
				return $actor;
			}
		}

		$actor = new Model_Actor();
		$actor->person = $person;
		$actor->role = $role;

		return $actor;
	}

}

?>
