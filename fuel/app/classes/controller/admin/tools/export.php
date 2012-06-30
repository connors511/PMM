<?php

class Controller_Admin_Tools_Export extends Controller_Admin
{

	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = array();
		$years = DB::select(DB::expr('MAX(released) as max'), DB::expr('MIN(released) as min'))
			->from('movies')
			->execute()
			->as_array();
		$data['year'] = $years[0];

		$data['movies'] = Model_Movie::find('all');
		$data['count'] = Model_Movie::find()->count();
		
		if (Input::post('submit', false) and Input::post('export_type', 'choose') == 'choose')
		{
			\Session::set_flash('error', 'You must choose an export type!');
		}
		else if (in_array(Input::post('submit', false), array('fields', 'all')))
		{
			if (Input::post('export_type', false) == 'fields')
			{
				$ids = Input::post('movie', false);
				if (!$ids)
				{
					$wheres = array();
				}
				else
				{
					$wheres[] = array('id', 'IN', $ids);
					if (Input::post('export_type',false) == 'fields')
					{
						$fields = Input::post('missing_fields', false);
						if ($fields)
						{
							foreach($fields as $f)
							{
								$wheres[] = array($f, '=', '');
							}
						}
					}
				}
				if (Input::post('export_type',false) == 'fields')
				{
					$fields = Input::post('missing_fields', false);
					if ($fields)
					{
						foreach($fields as $f)
						{
							//$wheres[] = array($f, '=', '');
							$wheres[] = array($f, 'IS', DB::expr('NULL'));
						}
					}
				}
				$where = array('where' => $wheres);
				//Debug::dump($where);die();
				$movies = Model_Movie::find('all', $where);
			}
			else if (Input::post('export_type', false) == 'all')
			{
				$movies = Model_Movie::find('all');
			}
			$files = File::read_dir(APPPATH . 'views' . DS . 'templates' . DS . 'export', 0);
			
			ob_start();
			$template = Input::post('export_template_user', '');
			if (!empty($template))
			{
				eval($template);
			}
			else
			{
				include(APPPATH . 'views' . DS . 'templates' . DS . 'export' . DS . $files[Input::post('export_template')]);
			}
			$res = ob_get_clean();

			$ext = Input::post('export_file_ext', 'html');

			$path = APPPATH . 'tmp' . DS;
			$filename = Str::random() . '.' . $ext;

			File::create($path, $filename, $res);

			Response::redirect('admin/tools/export/download/' . str_replace('.', '_', $filename));
		}
		else if (Input::post('export_type', false) == 'files')
		{
			$files = Input::post('export_files');
			$paths = array();
			foreach($files as $f)
			{
				foreach(Input::post($f.'_paths') as $p)
				{
					if (strlen($p) > 0)
					{
						$paths[$f] = $p;
					}
				}
			}
			// Figure out which movies should be exported..
			// TODO: Fix hardcoded
			$movies = Model_Movie::find('all', array(
			    'where' => array(
				array('id', 'IN', Input::post('movie'))
			    )
			));
			$results = array('error'=>0,'success'=>0);
			
			foreach((array)$movies as $movie)
			{
				foreach((array)$files as $f)
				{
					switch($f)
					{
						case "poster":
							// TODO: The poster should be stored locally
							if ($movie->save_poster($paths[$f]))
								$results['success']++;
							else
								$results['error']++;
							break;
						case "folder":
							break;
						case "fanart":
							foreach($movie->images as $img)
							{
								if ($img->file->export($paths[$f]))
									$results['success']++;
								else
									$results['error']++;
							}
							break;
						case "nfo":
							if ($movie->save_nfo($paths[$f]))
								$results['success']++;
							else
								$results['error']++;
							break;
						case "subtitles":
							foreach($movie->subtitles as $sub)
							{
								if ($sub->file->export($paths[$f]))
									$results['success']++;
								else
									$results['error']++;
							}
							break;
						default:
							break;
					}
				}
			}
			Session::set_flash('success',"Export had {$results['success']} successfull exports and {$results['error']} failed.");
		}
		
		$this->template->title = "Export";
		$this->template->content = View::forge('admin/tools/export/index', $data);
	}

	public function action_download($filename)
	{
		/* $filename = Input::get('p',false);
		  if (!$filename)
		  {
		  die();
		  } */
		$filename = str_replace('_', '.', $filename);

		$path = APPPATH . 'tmp' . DS;

		\Fuel\Core\File::download($path . $filename);

		//File::delete($path.$filename);
		//Response::redirect('admin/tools/export');
	}

}