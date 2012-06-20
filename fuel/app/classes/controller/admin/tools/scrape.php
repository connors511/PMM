<?php

class Controller_Admin_Tools_Scrape extends Controller_Admin {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$data['sources'] = Model_Source::find('all');
		$this->template->title = "Scrape";
		$this->template->content = View::forge('admin/tools/scrape/index', $data);
	}
	
	public function action_all($id)
	{
		$this->_scan($id, true);
	}
	
	public function action_missing($id)
	{
		$this->_scan($id, false);
	}
	
	public function _scan($id, $all)
	{
		$path = Model_Source::find($id);

		if ($path == null or $id == null)
		{
			Session::set_flash('error', 'Invalid path ID');
			Response::redirect('admin');
		}
		
		$movies = Model_Movie::find('all', array(
		    'related' => array(
			'file' => array(
			    'related' => array(
				'source' => array(
				    'where' => array(
					array(
					    'id', '=', $id
					)
				    )
				)
			    )
			)
		    )
		));

		try
		{
			foreach($movies as $movie)
			{
				Scanner_Movie::parse_movie($movie, $all);
			}
			
			//Session::set_flash('success', 'Scanned ' . ($new + $updated) . ' movies; ' . $new . ' was added and ' . $updated . ' was updated.');
		}
		catch (MissingScraperGroupException $e)
		{
			Session::set_flash('error', $e->getMessage());
		}
		Response::redirect('admin/tools/scrape');
	}
}