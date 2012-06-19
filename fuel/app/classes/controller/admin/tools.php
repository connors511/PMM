<?php

class Controller_Admin_Tools extends Controller_Admin
{

	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = array();
		$this->template->title = "Tools";
		$this->template->content = View::forge('admin/tools', $data);
	}

}

