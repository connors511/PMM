<?php

class Controller_Home extends Controller_Base
{
	public $template = 'home/template';
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$movies = Model_Movie::find('all');
		
		$this->template->set_global('movies',$movies);
		$this->template->set_global('dpage',10);
		$this->template->title = 'Movies';
	}
}