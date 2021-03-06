<?php

class Model_Io_Factory
{

	public static function parse_nfo($nfo, Model_Movie &$movie)
	{
		$files = File::read_dir(APPPATH . 'classes/model/io/');
		foreach ($files as $target => $types)
		{
			if (is_numeric($target))
			{
				// Base classes
				continue;
			}
			foreach ($types as $file)
			{
				$info = File::file_info(APPPATH . 'classes/model/io/' . $target . $file);
				$class = 'Model_Io_' . ucfirst(rtrim($target, '/')) . '_' . ucfirst($info['filename']);
				$io = new $class($nfo);
				if ($io->is_valid_nfo())
				{
					$io->import_movie($movie);
					return true;
				}
			}
		}
		return false;
	}
	
	public static function export_nfo(Model_Movie $movie, $folder, $file)
	{
		// TODO: Fetch from config
		$oi_class = 'Model_Io_Xbmc_Movie';
		$oi = new $oi_class($folder.$file);
		return $oi->export_movie($movie, $folder, $file);
	}

}

?>
