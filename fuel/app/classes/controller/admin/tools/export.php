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
		
		$this->template->title = "Export";
		$this->template->content = View::forge('admin/tools/export/index', $data);
	}
}