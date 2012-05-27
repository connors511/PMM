<?php

/**
 * Some methods might fail due to pcre.backtrack_limit when using preg_match_all
 */
class Scraper_Tmdb extends Scraper
{

	protected $_urls = array(
	    'search' => 'http://api.themoviedb.org/3/search/movie?query=%s',
	    'main' => 'http://api.themoviedb.org/3/movie/%s',
	    // TODO Get poster path from TMDb configuration via API?
	    'poster_url' => 'http://cf2.imgobject.com/t/p/w500'
	);
	protected $_fields = array(
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
	    'studio',
	    'votes',
	    'runtime',
	    'producers',
	    'actors',
	    'poster',
	);
	protected $_type = 'movies';
	protected $_author = 'Matthias Larsen';
	protected $_name = 'TMDb Scraper';
	protected $_version = '0.1';

	public function __construct()
	{
		\Config::load('api_keys');
	}

	public function download_url($url, $cache = true)
	{
		$glue = '?';
		if (strpos($url, '?') !== false)
		{
			$glue = '&';
		}
		$url .= $glue . 'api_key=' . \Config::get('tmdb.key');
		return json_decode(parent::download_url($url, $cache), true);
	}

	private function _get_helper($res, $field)
	{
		if (isset($res[$field]))
		{
			return $res[$field];
		}
		return false;
	}

	private function _return_helper($field, $ret_field = false, $url = 'main')
	{
		if (!$ret_field)
		{
			$ret_field = $field;
		}

		$res = $this->download_url_param($this->_urls[$url], $this->_id);
		if (($r = $this->_get_helper($res, $field)))
		{
			Log::debug("Getting {$field}. Found: '{$r}'");
			return $r;
		}
		if (in_array($ret_field, $this->_movie->properties()))
		{
			Log::debug("Getting {$field}. *NOT* found - returning old value.");
			return $this->_movie->{$ret_field};
		}
		else
		{
			Log::debug("Getting {$field}. *NOT* found - coult not return old value.");
			return '';
		}
	}

	public function search_site()
	{
		$url = sprintf($this->_urls['search'], urlencode($this->_movie->title), $this->_movie->released);
		$results = $this->download_url($url);

		if (empty($results['results']))
		{
			// Attempt to remove any chars or strings that might fuck the search up
			$strips = array(':', '-', 'edition','unrated','directors','cut');
			$url = sprintf($this->_urls['search'], urlencode(str_ireplace($strips, '', $this->_movie->title)), $this->_movie->released);
			$results = $this->download_url($url);
		}

		$bets = array();
		$current = $this->_movie->title . ':' . $this->_movie->released;
		foreach ($results['results'] as $result)
		{
			list($released,, ) = explode('-', $result['release_date']);
			if ($result['title'] == $this->_movie->title and $released == $this->_movie->released)
			{
				$this->_id = $result['id'];
				Log::debug("Direct match on '{$result['title']}' ({$result['id']})");
				break;
			}
			else
			{
				// The first result is probably the correct one, but anyway..
				$lev = levenshtein($current, $result['title'] . ':' . $released);
				$bets[$lev] = $result;
			}
		}

		if (!$this->_id)
		{
			ksort($bets);
			// TODO Config or ask user?
			$best_guess = current($bets);
			$this->_id = $best_guess['id'];
			Log::debug("Best guess is '{$best_guess['title']}' ({$best_guess['id']})");
		}
	}

	public function scrape_title()
	{
		// TODO: Config option to overwrite with original title?
		return $this->_return_helper('title');
	}

	public function scrape_originaltitle()
	{
		return $this->_return_helper('original_title', 'originaltitle');
	}

	public function scrape_released()
	{
		list($released,, ) = explode('-', $this->_return_helper('release_date', 'released'));
		return $released;
	}

	public function scrape_rating()
	{
		return $this->_return_helper('vote_average', 'rating');
	}

	public function scrape_directors()
	{
		
	}

	public function scrape_plot()
	{
		return $this->_return_helper('overview', 'plot');
	}

	public function scrape_plotsummary()
	{
		
	}

	public function scrape_contentrating()
	{
		
	}

	public function scrape_country()
	{
		
	}

	public function scrape_genres()
	{
		$res = $this->_return_helper('genres');
		$genres = array();
		foreach ($res as $g)
		{
			$g = $g['name'];
			$genre = Model_Genre::find('first', array(
				    'where' => array(
					array(
					    'name', '=', $g
					)
				    )
				));
			if ($genre == null)
			{
				$genre = new Model_Genre();
				$genre->name = $g;
			}
			$genres[] = $genre;
		}
		return $genres;
	}

	public function scrape_tagline()
	{
		return $this->_return_helper('tagline');
	}

	public function scrape_studio()
	{
		
	}

	public function scrape_votes()
	{
		return $this->_return_helper('vote_count', 'votes');
	}

	public function scrape_runtime()
	{
		return $this->_return_helper('runtime');
	}

	public function scrape_producers()
	{
		
	}

	public function scrape_actors()
	{
		
	}

	public function scrape_poster()
	{
		$poster = $this->_return_helper('poster_path');
		if ($poster)
		{
			return $this->_urls['poster_url'] . $poster;
		}
		return '';
	}

}