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
		$this->set_pagination(Uri::create('home'), 2, Model_Movie::find()->count());
		$movies = Model_Movie::find('all', array(
			    'related' => array(
				'stream_video'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));

		$this->template->set_global('movies', $movies);
		$this->template->set_global('dpage', 10);
		$this->template->title = 'Movies';
	}

}