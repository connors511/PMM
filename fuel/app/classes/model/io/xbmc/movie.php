<?php

class Model_Io_Xbmc_Movie extends Model_Io_Base
{

	private $_nfo;
	private $_schema;

	public function __construct($nfo)
	{
		$this->_nfo = $nfo;
		$this->_schema = APPPATH . 'views/schemas/xbmc_movie.xsd';
	}

	public function update_movie(Model_Movie &$movie)
	{
		$xml = simplexml_load_file($this->_nfo);
		$data = $this->simplexml2array($xml);
		foreach ($data as $key => $val)
		{
			if (in_array($key, array('director', 'actor', 'producer')))
			{
				//echo "Parsing {$key}<br>";
				foreach ($val as $v)
				{
					//Debug::dump($key,$v);
					$name = $v;
					if ($key == 'actor')
					{
						$name = $v['name'];
					}
					$class = 'Model_' . Inflector::classify($key);
					$model = $class::find('first', array(
						    'related' => array(
							'person' => array(
							    'where' => array(
								array('name', '=', $name)
							    )
							),
							'movie' => array(
							    'related' => array(
								'file' => array(
								    'where' => array(
									array('path','=',$movie->file->path)
								    )
								)
							    )
							)
						    )
						));
					if ($model == null)
					{
						$person = Model_Person::find('first', array(
							    'where' => array(
								array('name', '=', $name)
							    )
							));
						if ($person == null)
						{
							// TODO: Scrape the person?
							$person = new Model_Person();
							$person->name = $name;
						}
						$model = new $class();
						$model->person = $person;
						if ($key == 'actor')
						{
							$model->role = $v['role'];
						}
						$movie->{$key.'s'}[] = $model;
					}
				}
			}
			else if ($key == 'thumb')
			{
				// TODO: Download remote sources?
			}
			else if ($key == 'genre')
			{
				// TODO: Fix genre linked to movies with many-to-many
			}
			else
			{
				// The rest should be single attributes
				$movie->{$key} = $val;
			}
		}
		//$movie->save();
		//die();
		//\Debug::dump($movie);die();
	}

	public function is_valid_nfo()
	{
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		$doc->load($this->_nfo);
		if (!$doc->schemaValidate($this->_schema))
		{
			//$this->libxml_display_errors();
			return false;
		}

		return true;
	}

	function libxml_display_error($error)
	{
		$return = "<br/>\n";
		switch ($error->level)
		{
			case LIBXML_ERR_WARNING:
				$return .= "<b>Warning $error->code</b>: ";
				break;
			case LIBXML_ERR_ERROR:
				$return .= "<b>Error $error->code</b>: ";
				break;
			case LIBXML_ERR_FATAL:
				$return .= "<b>Fatal Error $error->code</b>: ";
				break;
		}
		$return .= trim($error->message);
		if ($error->file)
		{
			$return .= " in <b>$error->file</b>";
		}
		$return .= " on line <b>$error->line</b>\n";

		return $return;
	}

	function libxml_display_errors()
	{
		$errors = libxml_get_errors();
		foreach ($errors as $error)
		{
			print $this->libxml_display_error($error);
		}
		libxml_clear_errors();
	}

}

?>
