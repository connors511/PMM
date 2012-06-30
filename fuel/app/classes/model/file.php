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
	
	public function get_movie()
	{
		if ($this->movie != null)
		{
			return $this->movie;
		} else if ($this->image != null)
		{
			return $this->image->movie;
		} else if ($this->subtitle != null)
		{
			return $this->subtitle->movie;
		}
		return null;
	}
	
	public function resolve_path($pattern)
	{
		$new_path = preg_replace('#\$((\w|->|_|\((true|false)*\))+)#', "'.\$this->$1.'", $pattern);
		$new_path = str_replace('$this->movie->','$this->get_movie()->',$new_path);
		$new_path .= "'";
		if (substr($new_path, 0, 2) == "'.")
		{
			$new_path = substr($new_path, 2);
		}
		else
		{
			$new_path = "'" . $new_path;
		}
		//echo $new_path . '<br>';
		eval('$new_path = ' . $new_path . ';');
		
		return $new_path;
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
			$paths = (array)$path;
		}

		foreach ($paths as $path)
		{
			$new_path = $this->resolve_path($path);
			
			if ($this->image != null)
			{
				// Start at _1 for fanart
				$ext = strrchr($new_path, '.');
				$new_path = Str::increment(str_replace($ext, '', $new_path)) . $ext;
			} else if ($this->subtitle != null and $this->subtitle->language != null)
			{
				// Append language if it exists
				$ext = strrchr($new_path, '.');
				$new_path = str_replace($ext, '.'.$this->subtitle->language.$ext, $new_path);
			}
			if (file_exists($new_path))
			{
				while(file_exists($new_path))
				{
					$ext = strrchr($new_path, '.');
					$new_path = Str::increment(str_replace($ext, '', $new_path)) . $ext;
				}
			}
			if (copy($this->path, $new_path))
			{
				$model = Model_Source::query()
					->where(DB::expr("LOCATE(path, '{$new_path}')"),'=','0')
					->order_by(DB::expr("(LENGTH(path) - LENGTH(REPLACE(path, '{DS}', '')))"), 'desc')
					->get_one();
				// Exported outside sources
				// TODO: Seems to skip for everything. The above query doesnt seem to find the correct path
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
					$file->image = new Model_Image();
					$file->image->height = $this->image->height;
					$file->image->width = $this->image->width;
					$file->image->movie_id = $this->image->movie_id;
				}
				else if ($this->movie != null)
				{
					$file->movie = $this->movie;
				}
				else if ($this->subtitle != null)
				{
					$file->subtitle = new Model_Subtitle();
					$file->subtitle->language = $this->subtitle->language;
					$file->subtitle->movie_id = $this->subtitle->movie_id;
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
