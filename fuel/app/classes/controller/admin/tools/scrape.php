<?php

class Controller_Admin_Tools_Scrape extends Controller_Admin {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$this->template->title = "Scrape";
		$this->template->content = View::forge('admin/tools/export/index', $data);
		
	}
}