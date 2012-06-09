<?php

namespace Fuel\Tasks;

class Scraper_group
{
	public static function run()
	{
		$args = func_get_args();
		$movie = $args[0];
		$bool = func_num_args() == 1 ? false : $args[1];
		$m = \Model_Movie::find($movie);
		if ($m)
		{
			\Cli::write('Scraping '.$m->title);
			\Model_Scraper_Group::parse_movie($m, $bool);
			$m->save();
			\Queue\Job::create('Scraper_fanart', 'fanart', array($m->id));
			\Queue\Job::create('Scraper_subtitles', 'subtitles', array($m->id));
		}
		return;
	}
}