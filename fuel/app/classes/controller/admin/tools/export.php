<?php

class Controller_Admin_Tools_Export extends Controller_Admin {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$years = DB::select(DB::expr('MAX(released) as max'),DB::expr('MIN(released) as min'))
				->from('movies')
				->execute()
				->as_array();
		$data['year'] = $years[0];
		
		$data['movies'] = Model_Movie::find('all');
		$data['count'] = Model_Movie::find()->count();
		
		if (Input::post('submit', false) and Input::post('movie', false))
		{
			ob_start();
			$movies = Input::post('movie');
			$movies = Model_Movie::find('all', array(
			    'where' => array(
				array('id', 'IN', $movies)
			    )
			));
			$files = File::read_dir(APPPATH.'views'.DS.'templates'.DS.'export', 0);
			include(APPPATH.'views'.DS.'templates'.DS.'export'.DS.$files[Input::post('export_template')]);
			$res = ob_get_clean();
			
			$ext = Input::post('export_file_ext', 'html');
			
			$path = APPPATH.'tmp'.DS;
			$filename = Str::random().'.'.$ext;
			
			File::create($path, $filename, $res);
			
			Response::redirect('admin/tools/export/download/'.str_replace('.','_',$filename));
		}
		
		$this->template->title = "Export";
		$this->template->content = View::forge('admin/tools/export/index', $data);
	}
	
	public function action_download($filename)
	{
		/*$filename = Input::get('p',false);
		if (!$filename)
		{
			die();
		}*/
		$filename = str_replace('_','.',$filename);

		$path = APPPATH.'tmp'.DS;
		
		\Fuel\Core\File::download($path.$filename);
		
		//File::delete($path.$filename);
		
		//Response::redirect('admin/tools/export');
	}
}