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
			$name .= '.'.$this->ext();
		}
		else if ($with_ext !== false)
		{
			$name .= '.'.$with_ext;
		}
		return $name;
	}
	
	public function ext()
	{
		return pathinfo($this->path, PATHINFO_EXTENSION);
	}

}
