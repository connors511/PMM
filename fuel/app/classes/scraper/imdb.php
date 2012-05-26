<?php

/**
 * Some methods might fail due to pcre.backtrack_limit when using preg_match_all
 */
class Scraper_Imdb extends Scraper
{

	protected $_urls = array(
	    'main' => 'http://www.imdb.com/title/%s/combined',
	    'plot' => 'http://www.imdb.com/title/%s/plotsummary',
	    'summary' => 'http://www.imdb.com/title/%s/synopsis',
	    'cast' => 'http://www.imdb.com/title/%s/fullcredits',
	    'officialsites' => 'http://www.imdb.com/title/%s/officialsites',
	    'releaseinfo' => 'http://www.imdb.com/title/%s/releaseinfo'
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
	    //'country',
	    //'language',
	    'genres',
	    //'cast',
	    'tagline',
	    //'top250',
	    //'studio',
	    'votes',
	    //'releasedate',
	    'runtime',
	    'producers',
	    'actors',
	    'poster',
		//'mpaa',
		//'writers',
		//'poster'
	);
	protected $_type = 'movies';
	protected $_author = 'Matthias Larsen';
	protected $_name = 'IMDb Scraper';
	protected $_version = '0.4';

	public function __construct()
	{
		
	}

	public function search_site()
	{
		$url = sprintf('http://www.imdb.com/find?s=tt&q=%s+(%s)', urlencode($this->_movie->title), $this->_movie->released);
		$page = $this->download_url($url);
		$page = str_replace(array("\n", "\r", "<b>", "</b>"), "", $page);
		$page = preg_replace("#\s{2,}#", "", $page);

		$matches = array();
		$r = preg_match_all('#<title>(?:IMDb - )?(?<title>.+?) \((Video )?(?<released>\d{4})\)(?:.+?)rel="canonical" (?:.+?)/(?<id>tt\d{7})#s', $page, $matches);
		if ($r and !empty($matches['title'][0]))
		{
			Log::debug("Direct match on {$matches['title'][0]} ({$matches['id'][0]})");
			$results = array();
			foreach ($matches['id'] as $k => $id)
			{
				$results[] = array(
				    'id' => $id,
				    'title' => $matches['title'][$k],
				    'released' => $matches['released'][$k]
				);
			}
			if ($results[0]['title'] == $this->_movie->title && $results[0]['released'] == $this->_movie->released)
			{
				$this->_id = $results[0]['id'];
			}
			else
			{
				// Direct match should be 99% correct
				// TODO: Config option
				$this->_id = $results[0]['id'];
			}
		}
		else
		{
			preg_match_all('#\?link=/title/(?<id>tt\d{7})/\';">(?<title>.{1,100})</a> \((Video)?(?<released>\d{4})\)#', $page, $matches);
			if (count($matches) > 0)
			{
				$results = array();
				foreach ($matches['id'] as $k => $id)
				{
					$results[] = array(
					    'id' => $id,
					    'title' => $matches['title'][$k],
					    'released' => $matches['released'][$k]
					);
				}
				// Do we have a title + year match?
				$bets = array();
				$leven = array();
				$current = $this->_movie->title . ':' . $this->_movie->released;
				foreach ($results as $k => $r)
				{
					$lev = levenshtein($current, $r['title'] . ':' . $r['released']);
					$bets[$lev] = $r;
				}
				ksort($bets);
				// TODO Config or ask user?
				$best_guess = current($bets);
				$this->_id = $best_guess['id'];
				Log::debug("Best guess is {$best_guess['title']} ({$best_guess['id']})");
			}
			else
			{
				echo 'Skipping ' . $this->_movie->title;
			}
		}

		return false;
	}

	public function scrape_title()
	{
		// TODO: Config option to overwrite with original title?
		$title = $this->_scrape_title_helper('title');
		if ($title)
		{
			return $title;
		}
		return $this->_movie->title;
	}

	public function scrape_originaltitle()
	{
		$title = $this->_scrape_title_helper('original');
		if ($title)
		{
			return $title;
		}
		return $this->_movie->title;
	}

	/**
	 * Gets titles from imdb page
	 * @param string $get 'title', 'original' or 'alts'
	 * @return array|string|bool returns array on alts, otherwise string. returns false or empty array on failure
	 */
	public function _scrape_title_helper($get = false)
	{
		// TODO: Cache this?
		$html = $this->download_url_param($this->_urls['main'], $this->_id);
		$releaseInfoHtml = $this->download_url_param($this->_urls['releaseinfo'], $this->_id);
		$matches = array();
		$title = false;
		$title_alts = array();
		$title_orig = false;

		if (preg_match('#(<title>)(?<title>.*)( [(].*</title>)#', $html, $matches))
		{
			$title = $matches['title'];
		}
		if (preg_match('#\(AKA\)</a></h5>\s<table border="0" cellpadding="2">(?<html>.+?)</table>#s', $releaseInfoHtml, $alt_html))
		{
			if (preg_match_all('#<td>(?<name>.*?)</td>\s+?<td>(?<details>.*?)</td>#s', $alt_html['html'], $m_titles))
			{
				foreach ($m_titles['name'] as $k => $t)
				{
					if (strpos($t, 'imax') === FALSE and strpos($t, 'working ') === FALSE and strpos($t, 'fake ') === FALSE)
					{
						$title_alts[] = array(
						    'title' => $t,
						    'detail' => $m_titles['details'][$k]
						);
					}
				}
			}
		}
		if (strpos($html, 'title-extra') !== FALSE)
		{
			if (preg_match('#class="title-extra">(?<title>.*?) <i>\(original title\)</i>#s', $html, $m_orig))
			{
				if (!empty($m_orig['title']) and strlen(trim($m_orig['title'])) > 0)
				{
					$title_orig = trim($m_orig['title']);
				}
			}
		}

		if ($title)
		{
			$title = preg_replace('#\(\d{4}\)#', '', $title);
		}
		if ($title_orig)
		{
			$title_orig = preg_replace('#\(\d{4}\)#', '', $title_orig);
		}

		$titles = array(
		    'title' => $title,
		    'original' => $title_orig,
		    'alts' => $title_alts
		);

		if ($get and isset($titles[$get]))
		{
			return $titles[$get];
		}
		return $titles;
	}

	public function scrape_released()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);

		$matches = array();
		// TODO fix regex
		if (preg_match("#\((?<released1>\d{4})/.*?\)|\((?<released2>\d{4})\)#", $page, $matches))
		{
			if ($matches['released1'] != "")
			{
				return $matches['released1'];
			}
			if ($matches['released2'] != "")
			{
				return $matches['released2'];
			}
		}
		$page = $this->download_url_param($this->_urls['releaseinfo'], $this->_id);
		if (preg_match_all('#\?region=[A-Z]+?">(?<country>[a-zA-Z ]*?)</a>(.*?)/year/(?<released>\d{4})#s', $page, $matches))
		{
			$releases = array_combine($matches['country'], $matches['released']);
			// TODO Config option to select year, or promt for it
			if (isset($releases['USA']))
			{
				return $releases['USA'];
			}
			if (isset($releases['UK']))
			{
				return $releases['UK'];
			}
			return current($releases);
		}

		// return original if not found
		return $this->_movie->released;
	}

	public function scrape_rating()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);

		$matches = array();
		if (preg_match_all("#<div\sclass=\"starbar-meta\">\s*?<b>(?<rating>.*?)/10</b>#", $page, $matches))
		{
			return $matches['rating'][0];
		}
	}

	public function scrape_directors()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#Directed [bB]y (?<director>.*?)\.#', $page, $matches))
		{
			$directors = explode(',', $matches['director'][0]);
			$res = array();
			$res = Model_Person::find('all', array(
				    'where' => array(
					array('name', 'in', $directors)
				    )
				));

			if (count($res) < count($directors))
			{
				// We're missing some
				foreach ($res as $model)
				{
					if (isset($directors[$model->name]))
					{
						unset($directors[$model->name]);
					}
				}
				foreach ($directors as $dir)
				{
					$tmp = new Model_Person();
					$tmp->name = $dir;
					$res[] = $tmp;
				}
			}
			$dirs = array();
			foreach ($res as $k => $r)
			{
				$d = new Model_Director();
				$d->person = $r;
				$dirs[] = $d;
			}
			return $dirs;
		}
		else
		{
			
		}
		return $this->_movie->directors;
	}

	public function scrape_plot()
	{
		$page = $this->download_url_param($this->_urls['plot'], $this->_id);
		$matches = array();
		if (preg_match_all('#<p class="plotpar">(?<plot>.*?)<i>#s', $page, $matches))
		{
			return $this->_scrape_plot_helper($matches['plot'][0]);
		}
		else
		{
			$page = $this->download_url_param($this->_urls['summary'], $this->_id);
			if (preg_match_all('#<div id="swiki.2.1">(?<synopsis>.*?)</div>#s', $page, $matches))
			{
				return $this->_scrape_plot_helper($matches['synopsis'][0]);
			}
			else
			{
				// Fall back to the summary
				return $this->scrape_plotsummary();
			}
		}
		return $this->_movie->plot;
	}

	public function scrape_plotsummary()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#<h5>Plot:</h5>\s<div class="info-content">(?<plot>.*?)<a#s', $page, $matches))
		{
			return $this->_scrape_plot_helper($matches['plot'][0]);
		}
		else
		{
			
		}
		return $this->_movie->plotsummary;
	}

	private function _scrape_plot_helper($str)
	{
		$str = str_replace(array(
		    "Add synopsis &raquo;",
		    "Full synopsis &raquo;",
		    "Full summary &raquo;",
		    "See more &raquo;",
		    "|"), '', $str);
		return trim(html_entity_decode(trim($str)));
	}

	public function scrape_contentrating()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#<h5>Certification:</h5>(?<cert>.*?)</div>#', $page, $matches))
		{
			$cert = $matches['cert'][0];
			if (preg_match_all('#USA:(?<mpaa1>.*?)</a>|USA:(?<mpaa2>.*?)$#', $cert, $matches))
			{
				if (isset($matches['mpaa1']))
				{
					if (is_array($matches['mpaa1']))
					{
						// fml..
						foreach ($matches['mpaa1'] as $m)
						{
							if (strpos($m, 'PG') !== FALSE)
							{
								// Return the match that contains PG. Unrated could be matched too..
								return $m;
							}
						}
						return $matches['mpaa1'][0];
					}
					else
					{
						return $matches['mpaa1'][0];
					}
				}
				else if (isset($matches['mpaa2']))
				{
					return $matches['mpaa2'][0];
				}
			}
		}
		else
		{
			
		}
		return $this->_movie->contentrating;
	}

	public function scrape_genres()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#<a href=\"/Sections/Genres/(?<genre>[a-zA-Z-]*)(/\">|\">)#', $page, $matches))
		{
			$genres = array();
			foreach ($matches['genre'] as $g)
			{
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
		else
		{
			
		}
		return $this->_movie->genres;
	}

	public function scrape_tagline()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#<h5>Tagline:</h5>\s<div\sclass="info-content">(?<tagline>.*?)</div>#s', $page, $matches))
		{
			return strip_tags(str_replace(array(' more', 'See more &raquo;', 'See more', '&nbsp;&raquo;'), '', $matches['tagline'][0]));
		}
		else
		{
			
		}
		return $this->_movie->tagline;
	}

	public function scrape_votes()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#tn15more">(?<votes>.*?)</a>#', $page, $matches))
		{
			return str_replace(',', '', $matches['votes'][0]);
		}
		else
		{
			
		}
		return $this->_movie->votes;
	}

	public function scrape_runtime()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match('#Runtime:</h5><div class="info-content">.*?(?<runtime>\d*?) min#', $page, $matches))
		{
			return $matches['runtime'];
		}
		else
		{
			
		}
		return $this->_movie->runtime;
	}

	public function scrape_producers()
	{
		$page = $this->download_url_param($this->_urls['cast'], $this->_id);
		$matches = array();
		if (preg_match('#(<table.*?Produced by.*?</table>)#', $page, $match))
		{
			$page = $match[0];
			if (preg_match_all('#<a href="(?:.*?)/(?<id>nm[0-9]{7})/">(?<name>.{0,40})</a></td><td valign="top" nowrap="1"> .... </td><td valign="top"><a href="(?:.*?)">(?<role>.*?producer.*?)</a>#', $page, $matches))
			{
				echo "* joy for $this->_id<br>";
				$producers = array();
				foreach ($matches['name'] as $k => $name)
				{
					$role = trim($matches['role'][$k]);
					$producer = Model_Producer::find('all', array(
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

					if (count($producer) == 1)
					{
						$producer = current($producer);
					}
					else if (count($producer) > 1)
					{
						// Wtf?
						continue;
					}

					if ($producer == null)
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
						}
						$producer = new Model_Producer();
						$producer->person = $person;
						$producer->role = $role;
						$producers[] = $producer;
					}
				}
				if (!empty($producers))
				{
					return $producers;
				}
			}
			else
			{
				
			}
		}
		return $this->_movie->producers;
	}

	public function scrape_actors()
	{
		$page = $this->download_url_param($this->_urls['cast'], $this->_id);
		$matches = array();
		if (preg_match_all('#>(?<name>.{0,40}?)</a></td><td class="ddd"> ... </td><td class="char">(?<role>.*?)</td>#', $page, $matches))
		{
			$actors = array();
			foreach ($matches['role'] as $k => $role)
			{
				if (strpos($role, 'uncredited') === FALSE)
				{
					// Only take uncredited into account
					// TODO: Config option
					$role = strip_tags($role);

					$roles = explode('/', $role);

					$person = Model_Person::find('first', array(
						    'where' => array(
							array('name', '=', $matches['name'][$k])
						    )
						));

					if ($person == null)
					{
						$person = new Model_Person();
						$person->name = $matches['name'][$k];
					}

					foreach ($roles as $r)
					{
						$r = trim($r);
						$actor = Model_Actor::find('all', array(
							    'related' => array(
								'person' => array(
								    'where' => array(
									array(
									    'name', '=', $matches['name'][$k]
									)
								    )
								)
							    ),
							    'where' => array(
								array(
								    'role' => $r
								)
							    )
							));

						if (count($actor) == 1)
						{
							$actor = current($actor);
						}
						else if (count($actor) > 1)
						{
							// Wtf?
							continue;
						}

						if ($actor == null)
						{
							$actor = new Model_Actor();
							$actor->person = $person;
							$actor->role = $r;
							$actors[] = $actor;
						}
					}
				}
			}

			if (!empty($actors))
			{
				return $actors;
			}
		}
		else
		{
			
		}
		return $this->_movie->actors;
	}

	public function scrape_poster()
	{
		foreach (array('poster', 'product') as $type)
		{
			$page = $this->download_url(sprintf('http://www.imdb.com/title/%s/mediaindex?refine=%s', $this->_id, $type));
			$matches = array();
			if (preg_match_all('#(?<url>/rg/mediaindex/unknown-thumbnail/media/rm\d{10}/tt\d{7})#', $page, $matches))
			{
				foreach ($matches['url'] as $m)
				{
					$p = $this->download_url('http://www.imdb.com' . $m);
					if (preg_match('#src="(?<url>http://ia\.media-imdb\.com/images/M/(?<str>[A-Za-z0-9_]+?)@@\._V1\._SX(?<width>\d{3})_SY(?<height>\d{3})_\.jpg)"#', $p, $match))
					{
						// Just return the first match.
						// TODO: Config to ask for a selection on poster, or download all of them?
						if (intval($match['height']) >= 300)
						{
							return $match['url'];
						}
					}
				}
			}
			else
			{
				
			}
		}
		return $this->_movie->thumb;
	}

	public function scrape_writers()
	{
		$this->scrape_producers();
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all('#writerlist/(.*?)">(?<name>.*?)</a>(?<role>.*?)<br#', $page, $matches))
		{
			$writers = array();
			foreach ($matches['name'] as $k => $name)
			{
				$role = trim($matches['role'][$k]);
				$writer = Model_Writer::find('all', array(
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

				if (count($writer) == 1)
				{
					$writer = current($writer);
				}
				else if (count($writer) > 1)
				{
					// Wtf?
					continue;
				}

				if ($writer == null)
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
					}
					$writer = new Model_Producer();
					$writer->person = $person;
					$writer->role = $role;
					$writers[] = $writer;
				}
			}
			if (!empty($writers))
			{
				return $writers;
			}
		}
		else
		{
			
		}
		return $this->_movie->writers;
	}

	/* public function scrape_top250()
	  {
	  $page = $this->download_url_param($this->_urls['main'], $this->_id);
	  $matches = array();
	  if (preg_match_all('#Top 250: #(?<top250>\d{1,3})</a>#s', $page, $matches))
	  {
	  return $matches['top250'][0];
	  }
	  else
	  {

	  }
	  return $this->_movie->top250;
	  } */
}

?>
