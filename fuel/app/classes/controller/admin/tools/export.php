<?php

class Controller_Admin_Tools_Export extends Controller_Admin {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		$this->template->title = "Export";
		$this->template->content = View::forge('admin/tools/export/index', $data);
	}
}