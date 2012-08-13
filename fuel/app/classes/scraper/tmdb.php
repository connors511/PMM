<?php

/**
 * Some methods might fail due to pcre.backtrack_limit when using preg_match_all
 */
class Scraper_Tmdb extends Scraper
{

	protected $_urls = array(
	    'search' => 'http://api.themoviedb.org/3/search/movie?query=%s',
	    'main' => 'http://api.themoviedb.org/3/movie/%s',
	    'cast' => 'http://api.themoviedb.org/3/movie/%s/casts',
	    'images' => 'http://api.themoviedb.org/3/movie/%s/images',
	    // TODO Get poster path from TMDb configuration via API?
	    'poster_url' => 'http://cf2.imgobject.com/t/p/%s'
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
	    //'poster',
	);
	protected $_type = 'movies';
	protected $_author = 'Matthias Larsen';
	protected $_name = 'TMDb Scraper';
	protected $_version = '0.2';

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
			/*$t = $r;
			if (is_array($t))
			{
				$t = print_r($t, true);
			}
			Log::debug("Getting {$field}. Found: '{$t}'");*/
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
			$strips = array(':', '-', 'edition', 'unrated', 'directors', 'cut');
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
		$this->download_url_param($this->_urls['cast'], $this->_id);
		$crew = $this->_return_helper('crew', false, 'cast');
		if (!is_array($crew))
		{
			return false;
		}
		$directors = array();
		foreach ($crew as $c)
		{
			if (strpos(strtolower($c['job']), 'director') === false)
			{
				continue;
			}
			$res = Model_Person::find('all', array(
				    'where' => array(
					array('name', '=', $c['name'])
				    )
				));
			if (count($res) == 1)
			{
				$res = current($res);
			}
			else if (count($res) > 1)
			{
				// Wtf?
				continue;
			}
			if ($res == null)
			{
				$res = new Model_Person();
				$res->name = $c['name'];
			}

			$d = new Model_Director();
			$d->person = $res;
			$directors[] = $d;
		}
		return empty($directors) ? false : $directors;
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
		$countries = $this->_return_helper('production_countries', 'country');
		if (is_array($countries))
		{
			$c = $countries[0]['name'];
		}
		else
		{
			$c = "";
		}
		return $c;
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
		$crew = $this->_return_helper('crew', false, 'cast');
		if (!is_array($crew))
		{
			return false;
		}
		$producers = array();
		foreach ($crew as $c)
		{
			if (strpos(strtolower($c['job']), 'producer') === false)
			{
				continue;
			}

			$res = Model_Person::find('all', array(
				    'where' => array(
					array('name', '=', $c['name'])
				    )
				));
			if (count($res) == 1)
			{
				$res = current($res);
			}
			else if (count($res) > 1)
			{
				// Wtf?
				continue;
			}
			if ($res == null)
			{
				$res = new Model_Person();
				$res->name = $c['name'];
			}

			$p = new Model_Producer();
			$p->person = $res;
			$p->role = $c['job'];
			$producers[] = $p;
		}

		return empty($producers) ? false : $producers;
	}

	public function scrape_actors()
	{
		$cast = $this->_return_helper('cast', false, 'cast');
		if (!is_array($cast))
		{
			return false;
		}

		$actors = array();
		foreach ($cast as $c)
		{
			if (empty($c['character']))
			{
				continue;
			}
			
			$actors[] = $this->get_actor($c['name'], $c['character']);
		}
		return $actors;
	}

	public function scrape_poster()
	{
		$posters = $this->_return_helper('posters', false, 'images');
		$poster_sizes = array('original'); // Other sizes includes w92, w154, w185, w342
		/*foreach($posters as $poster)
		{
			foreach($poster_sizes as $size)
			{
				$wi = new Model_Web_Image();
				$wi->url = sprintf($this->_urls['poster_url'], $size) . $poster['file_path'];
				$wi->height = $poster['height'];
				$wi->width = $poster['width'];
				$wi->type = Model_Web_Image::TYPE_POSTER;
				$wi->source = Model_Web_Image::SOURCE_MOVIE;
				$wi->movie = $this->_movie;
				$wi->save();
			}
		}*/


		$poster = $this->_return_helper('poster_path');
		if ($poster)
		{
			//return sprintf($this->_urls['poster_url'], 'w500') . $poster;
		}
		return false;
	}

}