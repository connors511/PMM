<?php

class Scanner_Movie implements IScanner
{

	protected static $regex_moviefolder = '/\.(mkv|nfo|mp4)$/';
	protected static $regex_movie_file = '/(?P<file>.+)\.(mkv|mp4|avi)$/';
	protected static $regex_subtitles = '/\.(srt|sub)$/';
	protected static $regex_subtitles_lang = '/\.(?P<lang>[a-z]{2})\.(srt|sub)$/';
	protected static $valid_image_extensions = array('png', 'jpg', 'jpeg');
	private $_source;
	private $_inserts;

	public function get_author()
	{
		return "Matthias Larsen";
	}

	public function get_name()
	{
		return "Default movie scanner";
	}

	public function get_type()
	{
		return "Movie";
	}

	public function get_version()
	{
		return "0.1";
	}

	public function __construct(Model_Source $source)
	{
		$this->_source = $source;
	}

	public function get_and_reset_inserts()
	{
		$tmp = $this->_inserts;
		$this->_inserts = array();
		return $tmp;
	}

	public function scan()
	{
		$this->scan_dir($this->_source->path);
		
		Debug::dump($this->_inserts);
	}

	public function scan_dir($dir, $parent = "", $fullpath = "")
	{
		// Set the fullpath to the starting dir
		if ($fullpath == "")
		{
			$fullpath = $dir . DS;
		}

		if (is_string($dir) and is_dir($dir))
		{
			// Load the dirs
			$dirs = File::read_dir($dir, 0);
		}
		else
		{
			// We already got some to scan
			$dirs = $dir;
		}

		foreach ($dirs as $p => $dir)
		{
			if (is_array($dir))
			{
				if (!self::is_fanart_folder($dir) and self::is_movie_folder($dir))
				{
					// Process movie
					self::parse_movie($p, $dir, $fullpath . $parent . $p);
				}
				else if (self::is_fanart_folder($dir))
				{
					// Just continue.. Fanart is handled by parse_movie
				}
				else
				{
					// Most likely a top level dir
					self::scan_dir($dir, $p, $fullpath . $parent);
				}
			}
		}
	}

	public static function is_movie_folder($dir)
	{
		if (!is_array($dir))
		{
			return false;
		}

		foreach ($dir as $p => $file)
		{
			if (is_array($file))
			{
				continue;
			}

			if (preg_match(self::$regex_moviefolder, $file))
			{
				return true;
			}
		}
		return false;
	}

	public static function is_fanart_folder($dir)
	{
		return !is_array($dir) and in_array(rtrim($dir, '/'), array('extrathumbs', 'extrafanart'));
	}

	public static function get_fanart_folder($root)
	{
		foreach (array('extrathumbs/', 'extrafanart/') as $dir)
		{
			if (is_dir(rtrim($root, '/') . DS . $dir))
			{
				return rtrim($root, '/') . DS . $dir;
			}
		}
		return false;
	}

	public static function get_subtitles(Array $dir)
	{
		$subtitles = array();
		foreach ($dir as $p => $file)
		{
			if (is_array($file))
			{
				continue;
			}

			if (preg_match(self::$regex_subtitles, $file))
			{
				$subtitles[] = $file;
			}
		}

		return empty($subtitles) ? false : $subtitles;
	}

	public static function get_nfo(Array $dir)
	{
		foreach ($dir as $p => $file)
		{
			if (is_array($file))
			{
				continue;
			}

			if (strpos($file, '.nfo') !== FALSE)
			{
				return $file;
			}
		}

		return false;
	}

	public static function get_movie(Array $dir)
	{
		// TODO: Add support for cd's, dvd's and BDMV
		foreach ($dir as $p => $file)
		{
			if (is_array($file))
			{
				continue;
			}

			if (preg_match(self::$regex_movie_file, $file))
			{
				return $file;
			}
		}
	}

	public function parse_movie($dir, $files, $fullpath)
	{
		$matches = array();
		$inserts = array('movie' => 0, 'fanart' => 0, 'subtitles' => 0);

		// Is the structure <movie name>/<files>
		if (preg_match('/(?P<title>.+) \((?P<year>\d+)\)/', $dir, $matches))
		{
			// Using <title> (<year>)/<movie> structure
			$movie_file = self::get_movie($files);
			if ($movie_file == false)
			{
				// Somehow, we've got a non-movie file :/
				return;
			}
			$movie = Model_Movie::find('all', array(
				    'related' => array(
					'file' => array(
					    'where' => array(
						array(
						    'path', '=', $fullpath . $movie_file
						)
					    )
					)
				    )
				));

			if (count($movie) == 1)
			{
				$movie = current($movie);
			}
			else if (count($movie) > 1)
			{
				return;
			}

			// Either path doesnt exist, or the movie is somehow not linked to the path
			if ($movie == null)
			{
				$movie = new Model_Movie();
				$file = Model_File::find('first', array(
					    'where' => array(
						array('path', '=', $fullpath . $movie_file)
					    )
					));

				if ($file == null)
				{
					// Path not registred
					$movie->file = new Model_File();
					$movie->file->path = $fullpath . $movie_file;
					$movie->file->source = $this->_source;
				}
				else
				{
					// TODO: Why do we have a file that's not connected to a movie?
					$movie->file = $file;
				}

				$movie->title = $matches['title'];
				$movie->released = $matches['year'];

				$inserts['movie'] = $movie->title;

				if (($nfo = self::get_nfo($files)) !== FALSE)
				{
					// TODO: Should be config item, if nfo overwrites a new scrape?
					Model_Io_Factory::parse_nfo($fullpath . $nfo, $movie);
				}
				else
				{
					// Get new data
					Model_Scrapergroup_Movie::parse_movie($movie);
				}
			}
			else
			{
				Model_Scrapergroup_Movie::parse_movie($movie, false);
				//Debug::dump(array($movie->title, $movie->released), $matches);
				// Uhm.. Path is registred to a movie. Update missing fields?
				if ($movie->title != $matches['title'] or $movie->released != $matches['year'])
				{
					// Ask user if he wants to force an update?
					// Or perhaps, manually select the movie?
				}
			}

			if ($fanart_folder = self::get_fanart_folder($fullpath))
			{
				$fanart = File::read_dir($fanart_folder);
				$fanarts = array();
				foreach ($fanart as $img)
				{
					$info = File::file_info($fanart_folder . $img);
					if (!in_array($info['extension'], self::$valid_image_extensions))
					{
						continue;
					}
					// FIXME: Can we assume that the file isnt registred instead of checking for missing link?
					$im = Model_Image::find('all', array(
						    'related' => array(
							'file' => array(
							    'where' => array(
								array(
								    'path', '=', $fanart_folder . $img
								)
							    )
							),
							'movie'
						    )
						));

					if (count($im) == 1)
					{
						$im = current($im);
					}
					else if (count($im) > 1)
					{
						// That is just fucked up
						Debug::dump($im);
						continue;
					}

					if ($im == null || $im->movie == null)
					{
						$im = new Model_Image();
						$im->file = new Model_File();
						$im->file->path = $fanart_folder . $img;
						$im->file->source = $this->_source;

						if (filesize($fanart_folder . $img) <= 0)
						{
							continue;
						}

						try
						{
							$image = Image::load($fanart_folder . $img);
							$sizes = $image->sizes();

							$im->height = $sizes->height;
							$im->width = $sizes->width;
						}
						catch (RuntimeException $e)
						{
							// GD lib not found, so we cant get image height and width
							$im->height = 0;
							$im->width = 0;
						}
						catch (Exception $e)
						{
							continue;
						}

						$movie->images[] = $im;
						$inserts['fanart']++;
					}
				}
			}
			else
			{
				// Scrape it?
			}

			if ($subtitles = self::get_subtitles($files))
			{
				foreach ($subtitles as $sub)
				{
					// FIXME: Can we assume that the file isnt registred instead of checking for missing link?
					$su = Model_Subtitle::find('all', array(
						    'related' => array(
							'file' => array(
							    'where' => array(
								array(
								    'path', '=', $fullpath . $sub
								)
							    )
							),
							'movie'
						    )
						));

					if (count($su) == 1)
					{
						$su = current($su);
					}
					else if (count($su) > 1)
					{
						// Wtf?
						return;
					}

					$matches = array();
					preg_match(self::$regex_subtitles_lang, $sub, $matches);

					if ($su == null || $su->movie == null)
					{
						$su = new Model_Subtitle();
						$su->file = new Model_File();
						$su->file->path = $fullpath . $sub;
						$su->file->source = $this->_source;

						$inserts['subtitles']++;

						$matches and $su->language = $matches['lang'];
						$movie->subtitles[] = $su;
					}
				}
			}
			else
			{
				// Scrape it?
			}

			$movie->save();
		}
		else
		{
			// Or one folder with all movies?
		}

		if (!empty($inserts) && $inserts['movie'] != 0)
		{
			$this->_inserts[] = $inserts;
		}
	}

}

?>
