<?php

class Model_File extends \Orm\Model
{

	protected static $_properties = array(
	    'id',
	    'path',
	    'created_at',
	    'updated_at',
	    'source_id',
	    'size',
	    'realpath'
	);
	protected static $_has_one = array(
	    'image',
	    'subtitle',
	    'movie',
	);
	protected static $_belongs_to = array(
	    'source'
	);
	protected static $_observers = array(
	    'Orm\Observer_CreatedAt' => array(
		'events' => array('before_insert'),
		'mysql_timestamp' => false,
	    ),
	    'Orm\Observer_UpdatedAt' => array(
		'events' => array('before_save'),
		'mysql_timestamp' => false,
	    ),
	    'Observer_Fileinfo' => array(
		'events' => array('before_insert')
	    ),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('path', 'Path', 'required');
		$val->add_field('source_id', 'Source', 'required');

		return $val;
	}

	public function formatted_size($dec = 1)
	{
		return Num::format_bytes($this->size, $dec);
	}

	public function folder($realpath = false)
	{
		$path = $realpath ? $this->realpath : $this->path;
		return dirname($path);
	}

	public function name($with_ext = true)
	{
		$name = pathinfo($this->path, PATHINFO_FILENAME);
		if ($with_ext === true)
		{
			$name .= '.' . $this->ext();
		}
		else if ($with_ext !== false)
		{
			$name .= '.' . $with_ext;
		}
		return $name;
	}

	public function ext()
	{
		return pathinfo($this->path, PATHINFO_EXTENSION);
	}

	/**
	 * Copies the image to another location
	 * @param string $path Either a config key or a path.
	 *		 array of paths is supported
	 * @return bool true if the image was successfully coppied
	 */
	public function export($path = 'fanart')
	{
		// The path is either the save location or a key in the config file
		$paths = \Config::get('settings.export.save_locations.' . $path, $path);
		if (!is_array($path))
		{
			$paths = array($path);
		}

		foreach ($paths as $path)
		{
			$new_path = preg_replace('#\$((\w|->|_|\((true|false)*\))+)#', "'.\$this->$1.'", $path);
			$new_path .= "'";
			if (substr($new_path, 0, 2) == "'.")
			{
				$new_path = substr($new_path, 2);
			}
			else
			{
				$new_path = "'" . $new_path;
			}
			//echo $pattern . '<br>';
			eval('$new_path = ' . $new_path . ';');

			if (copy($this->file->path, $new_path))
			{
				$model = Model_Source::find('first', array(
					    'where' => array(
						array(
						    \DB::expr("LOCATE(path, {$new_path}) = 0")
						)
					    ),
					    'order_by' => array(
						DB::expr("(LENGTH(path) - LENGTH(REPLACE(path, '{DS}', '')))") => 'desc'
					    )
					));
				// Exported outside sources
				if ($model == null)
				{
					continue;
				}

				$file = new Model_File();
				$file->path = $new_path;
				$file->source = $model;

				// Figure out what we're exporting
				if ($this->image != null)
				{
					$file->image = $this->image;
				}
				else if ($this->movie != null)
				{
					$file->movie = $this->movie;
				}
				else if ($this->subtitle != null)
				{
					$file->subtitle = $this->subtitle;
				}
				$file->save();
			}
			else
			{
				return false;
			}
		}
		return true;
	}

}
