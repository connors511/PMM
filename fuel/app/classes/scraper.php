<?php

/**
 *
 * @author Matthias
 */
abstract class Scraper
{

// Name of the scraper
	public abstract function get_name();

// Author of the scraper
	public abstract function get_author();

// Version of the scraper
	public abstract function get_version();

// Type of scraper: Movie, TV, People
	public abstract function get_type();

// Fields of getType that can be scraped
	public abstract function get_supported_fields();

// Downloads a webpage
	protected function download_url($url, $cache = true)
	{
		try
		{
			$page = Cache::get(sha1($url));
			echo 'got cache for '.$url.'<br>';
		}
		catch (\CacheNotFoundException $e)
		{
			$page = file_get_contents($url);
			echo 'downloaded '.$url.'<br>';
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


	public function populate_all_by_id($id)
	{
		$this->_id = $id;
		foreach ($this->_fields as $field)
		{
			$func = 'scrape_' . $field;
			$this->_movie->{$field} = $this->{$func}();
		}
	}
}

?>
