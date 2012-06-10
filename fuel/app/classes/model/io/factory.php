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

}

?>
