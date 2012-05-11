<?php

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
	    'released',
	    'rating',
	    'directors',
	    'plot',
	    'plotsummary',
	    'contentrating',
	    //'country',
	    //'language',
	    //'genre',
	    //'cast',
	    'tagline',
	    //'top250',
	    //'studio',
	    'votes',
	    //'releasedate',
	    'runtime',
		//'mpaa',
		//'writers',
		//'poster'
	);
	protected $_movie;
	protected $_id;

	public function get_author()
	{
		return "Matthias Larsen";
	}

	public function get_name()
	{
		return "IMDb Scraper";
	}

	public function get_supported_fields()
	{
		return implode(':', array());
	}

	public function get_type()
	{
		return implode(':', array("Movies", "TV", "People"));
	}

	public function get_version()
	{
		return "0.1";
	}

	public function __construct(Model_Movie &$movie)
	{
		$this->_movie = $movie;
	}

	public function search_imdb($all_fields)
	{
		$url = sprintf('http://www.imdb.com/find?s=tt&q=%s+(%s)', urlencode($this->_movie->title), $this->_movie->released);
		$page = $this->download_url($url);
		$page = str_replace(array("\n", "\r", "<b>", "</b>"), "", $page);
		$page = preg_replace("#\s{2,}#", "", $page);

		$matches = array();
		$r = preg_match_all('#<title>(?:IMDb - )?(?<title>.+?) \((?<released>\d{4})\)(?:.+?)rel="canonical" (?:.+?)/(?<id>tt\d{7})#s', $page, $matches);
		if ($r and !empty($matches['title'][0]))
		{
			echo "- got direct match on {$matches['title'][0]} ({$matches['id'][0]})<br>";
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
				$this->populate_all_by_id($results[0]['id']);
			}
			else
			{
				// Direct match should be 99% correct
				// TODO: Config option
				$this->populate_all_by_id($results[0]['id']);
			}
		}
		else
		{
			preg_match_all('#\?link=/title/(?<id>tt\d{7})/\';">(?<title>.{1,100})</a> \((?<released>\d{4})\)#', $page, $matches);
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
				foreach ($results as $k => $r)
				{
					// TODO: Add some sort of rating for the bets?
					if ($this->_movie->title == $r['title'] && $this->_movie->released == $r['released'])
					{
						// Pretty safe bet..
						// TODO: Config option to allow a title + year match to be auto selected?
						$bets = array();
						$bets[] = $r;
						break;
					}
					else if ($this->_movie->title == $r['title'])
					{
						if (abs(intval($this->_movie->released) - intval($r['released']) < 2))
						{
							$bets[] = $r;
						}
						else
						{
							$bets[] = $r;
						}
					}
					else if ($this->_movie->released == $r['released'])
					{
						// Pretty lousy match
						$bets[] = $r;
					}
				}

				if (is_array($bets))
				{
					$bet = current($bets);
					if ($bet)
					{
						if ($all_fields)
						{
							$this->populate_all_by_id($bet['id']);
						}
						else
						{
							$this->populate_missing_by_id($bet['id']);
						}
					}
				}
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
		$html = $this->download_url_param($this->_urls['main'], $this->_id);
		$releaseInfoHtml = $this->download_url_param($this->_urls['releaseinfo'], $this->_id);
		return $this->_movie->title;
	}

	public function scrape_released()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);

		$matches = array();
		// TODO fix regex
		if (preg_match_all("#\((?<released1>\d{4})/.*?\)|\((?<released2>\d{4})\)#", $page, $matches))
		{
			
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
			$directors = $matches['director'];
			$res = array();
			/* foreach($directors as $d)
			  {
			  $res
			  } */
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

	public function scrape_genre()
	{
		
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
		if (preg_match_all('#Runtime:</h5><div class="info-content">.*?(?<runtime>\d*?) min#', $page, $matches))
		{
			return $matches['runtime'][0];
		}
		else
		{
			
		}
		return $this->_movie->runtime;
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
