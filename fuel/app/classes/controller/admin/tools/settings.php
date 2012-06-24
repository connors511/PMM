<?php

class Controller_Admin_Tools_Settings extends Controller_Admin
{

	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = array();
		$this->template->title = "Settings";
		$this->template->content = View::forge('admin/tools/settings/index', $data);
	}
}