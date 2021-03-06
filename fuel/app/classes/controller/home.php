<?php

class Controller_Home extends Controller_Base
{

	public $template = 'home/template';

	public function before()
	{
		if (\Fuel\Core\Input::is_ajax() && Uri::segment(2) != 'watch')
		{
			$this->template = 'home/ajax';
		}
		parent::before();
	}

	public function action_index()
	{
		$this->set_pagination(Uri::create('home'), 2, Model_Movie::find()->count(), 50);
		$movies = Model_Movie::find('all', array(
			    'related' => array(
				'stream_video'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));

		$this->template->set_global('movies', $movies);
		$this->template->set_global('count', count($movies));
		$this->template->title = 'Movies';

		if (Input::is_ajax())
		{
			$arr = array(
			    'total' => \Pagination::total_items(),
			    'perpage' => \Pagination::$per_page,
			    'count' => count($movies),
			    'movies' => $this->template->render()
			);

			// Handle it better?
			echo json_encode($arr);
			die();
		}
	}

	public function action_search($term = "")
	{
		$this->set_pagination(Uri::create('home'), 4, Model_Movie::find()->where('title', 'like', '%' . $term . '%')->count(), 50);
		$movies = Model_Movie::find('all', array(
			    'related' => array(
				'stream_video'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset,
			    'where' => array(
				array('title', 'like', '%' . $term . '%')
			    )
			));

		$this->template->set_global('movies', $movies);
		$this->template->set_global('count', count($movies));
		$this->template->set_global('term', $term);
		$this->template->title = 'Movies';

		if (Input::is_ajax())
		{
			$arr = array(
			    'total' => \Pagination::total_items(),
			    'perpage' => \Pagination::$per_page,
			    'count' => count($movies),
			    'movies' => $this->template->render()
			);

			// Handle it better?
			echo json_encode($arr);
			die();
		}
	}

	public function action_watch($id)
	{
		$movie = Model_Movie::find($id);
		if ($movie == null)
		{
			throw new \Fuel\Core\HttpNotFoundException();
		}

		return View::forge('home/watch', array('movie' => $movie));
	}

	public function action_play($id)
	{
		$movie = Model_Movie::find($id);
		if ($movie == null)
		{
			throw new \Fuel\Core\HttpNotFoundException();
		}

		return View::forge('home/play', array('id' => $movie->id));
	}

	public function action_stream($id)
	{
		$movie = Model_Movie::find($id);
		if ($movie == null)
		{
			throw new \Fuel\Core\HttpNotFoundException();
		}

		$stream = new Vstream();
		$stream->stream($movie->file->path);
		die();
	}

}