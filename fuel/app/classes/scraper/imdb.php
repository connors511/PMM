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

	public function search_imdb()
	{
		$url = sprintf('http://www.imdb.com/find?s=tt&q=%s (%s)', $this->_movie->title, $this->_movie->released);
		$page = $this->download_url($url);
		$page = str_replace(array("\n", "\r", "<b>", "</b>"), "", $page);
		$page = preg_replace("#\s{2,}#", "", $page);

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

			if (count($bets) > 0)
			{
				end($bets);
				$bet = current($bets);
				$this->populate_all_by_id($bet['id']);
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
		
	}

	public function scrape_plot()
	{
		
	}

	public function scrape_plotsummary()
	{
		$page = $this->download_url_param($this->_urls['main'], $this->_id);
		$matches = array();
		if (preg_match_all("#<h5>Plot:</h5>\s<div class=\"info-content\">(?<plot>.*?)<a#s", $page, $matches))
		{
			return $this->_scrape_plot_helper($matches['plot'][0]);
		} else {
			Debug::dump($this->_movie->title, $matches);
			die();
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
		return html_entity_decode(trim($str));
	}

	public function scrape_contentrating()
	{
		
	}

	public function scrape_genre()
	{
		
	}

	public function scrape_tagline()
	{
		
	}

	public function scrape_votes()
	{
		
	}

	public function scrape_runtime()
	{
		
	}

}

?>
