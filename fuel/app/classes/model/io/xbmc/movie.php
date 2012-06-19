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
	
	// $this->export_movie($movie, $movie->file->folder(), $movie->file->name('nfo')));
	public function export_movie(Model_Movie $movie, $folder, $file)
	{
		$genres = array();
		$directors = array();
		$actors = array();
		foreach($movie->genres as $g)
		{
			$genres[] = $g->name;
		}
		foreach($movie->directors as $d)
		{
			$directors[] = $d->person->name;
		}
		foreach($movie->actors as $a)
		{
			$actors[] = array(
			    'name' => $a->person->name,
			    'role' => $a->role
			);
		}
		$data = array(
		    'title' => $movie->title,
		    'originaltitle' => $movie->originaltitle,
		    //'sorttitle' => $movie->sorttitle,
		    //'set' => array('unbounded',$movie->set),
		    'rating' => $movie->rating,
		    'released' => $movie->released,
		    //'top250' => $movie->top250,
		    'votes' => $movie->votes,
		    //'outline' => $movie->outline,
		    'plot' => $movie->plot,
		    'tagline' => $movie->tagline,
		    'runtime' => $movie->runtime,
		    'thumb' => $movie->thumb,
		    //'mpaa' => $movie->mpaa,
		    //'playcount' => $movie->playcount,
		    //'watched' => $movie->watched,
		    //'id' => $movie->id,
		    'filenameandpath' => $movie->file->path,
		    'trailer' => $movie->trailer_url,
		    'genre' => array('unbounded',$genres),
		    //'credits' => $movie->credits,
		    //'fileinfo' => $movie->fileinfo,
		    'director' => array('unbounded',$directors),
		    'actor' => array('unbounded',$actors),
		);
		
		$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><movie />");
		foreach($data as $key => $value)
		{
			if (is_array($value))
			{
				if (isset($value[0]) and $value[0] == 'unbounded')
				{
					foreach($value[1] as $v)
					{
						if (is_array($v))
						{
							$node = $structure->addChild($key);
							foreach($v as $k => $val)
							{
								$val = htmlspecialchars(html_entity_decode($val, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
								empty($val) or $node->addChild($k,$val);
							}
						}
						else
						{
							$v = htmlspecialchars(html_entity_decode($v, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
							empty($v) or $structure->addChild($key, $v);
						}
					}
				}
				else
				{
					
				}
			}
			else
			{
				$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
				
				empty($value) or $structure->addChild($key, $value);
			}
		}
		
		$xml = $structure->asXML();
		if ($this->is_valid_nfo($xml))
		{
			$dom = new DOMDocument();
			$dom->loadXML($xml);
			$dom->formatOutput = true;
			
			try {
				if (file_exists(rtrim($folder,"/").DS.$file))
				{
					File::delete(rtrim($folder,"/").DS.$file);
				}
				File::create($folder, $file, $dom->saveXML());
				return true;
			} catch(Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function import_movie(Model_Movie &$movie)
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
				try {
					// Handle filenameandpath
					// The rest should be single attributes
					$movie->{$key} = $val;
				} catch(Exception $e) {
					
				}
			}
		}
		$movie->save();
		//die();
		//\Debug::dump($movie);die();
	}

	public function is_valid_nfo($nfo = false, $schema = false)
	{
		$nfo or $nfo = $this->_nfo;
		$schema or $schema = $this->_schema;
		
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		if (file_exists($nfo))
		{
			$doc->load($nfo);
		}
		else
		{
			$doc->loadXML($nfo);
		}
		if (!$doc->schemaValidate($schema))
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
