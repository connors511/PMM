<?php

namespace Fuel\Tasks;

class Scraper_subtitles
{
	public static function run()
	{
		$args = func_get_args();
		$movie = $args[0];
		$m = \Model_Movie::find($movie);
		if ($m)
		{
			\Cli::write('Scraping fanart for '.$m->title);
			\Scanner_Movie::parse_subtitles($m);
		}
		return;
	}
}