<?php

class Controller_Admin_Movies extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/movies'), 3, Model_Movie::find()->count());
		$data['movies'] = Model_Movie::find('all', array(
			    'related' => array(
				'genres'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Movies";
		$this->template->content = View::forge('admin/movies/index', $data);
	}

	public function action_view($id = null)
	{
		$data['movie'] = Model_Movie::find($id);

		$this->template->title = "Movie";
		$this->template->content = View::forge('admin/movies/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Movie::validate('create');

			if ($val->run())
			{
				$movie = Model_Movie::forge(array(
					    'title' => Input::post('title'),
					    'plot' => Input::post('plot'),
					    'plotsummary' => Input::post('plotsummary'),
					    'tagline' => Input::post('tagline'),
					    'imdb_rating' => Input::post('imdb_rating'),
					    'imdb_votes' => Input::post('imdb_votes'),
					    'released' => Input::post('released'),
					    'runtime' => Input::post('runtime'),
					    'runtime_file' => Input::post('runtime_file'),
					    'contentrating' => Input::post('contentrating'),
					    'originaltitle' => Input::post('originaltitle'),
					    'trailer_url' => Input::post('trailer_url'),
					    'file_id' => Input::post('file_id'),
					));

				if ($movie and $movie->save())
				{
					Session::set_flash('success', 'Added movie #' . $movie->id . '.');

					Response::redirect('admin/movies');
				}
				else
				{
					Session::set_flash('error', 'Could not save movie.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Movies";
		$this->template->content = View::forge('admin/movies/create');
	}

	public function action_edit($id = null)
	{
		$movie = Model_Movie::find($id);
		$val = Model_Movie::validate('edit');

		if ($val->run())
		{
			$movie->title = Input::post('title');
			$movie->plot = Input::post('plot');
			$movie->plotsummary = Input::post('plotsummary');
			$movie->tagline = Input::post('tagline');
			$movie->imdb_rating = Input::post('imdb_rating');
			$movie->imdb_votes = Input::post('imdb_votes');
			$movie->released = Input::post('released');
			$movie->runtime = Input::post('runtime');
			$movie->runtime_file = Input::post('runtime_file');
			$movie->contentrating = Input::post('contentrating');
			$movie->originaltitle = Input::post('originaltitle');
			$movie->trailer_url = Input::post('trailer_url');
			$movie->file_id = Input::post('file_id');

			if ($movie->save())
			{
				Session::set_flash('success', 'Updated movie #' . $id);

				Response::redirect('admin/movies');
			}
			else
			{
				Session::set_flash('error', 'Could not update movie #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$movie->title = $val->validated('title');
				$movie->plot = $val->validated('plot');
				$movie->plotsummary = $val->validated('plotsummary');
				$movie->tagline = $val->validated('tagline');
				$movie->imdb_rating = $val->validated('imdb_rating');
				$movie->imdb_votes = $val->validated('imdb_votes');
				$movie->released = $val->validated('released');
				$movie->runtime = $val->validated('runtime');
				$movie->runtime_file = $val->validated('runtime_file');
				$movie->contentrating = $val->validated('contentrating');
				$movie->originaltitle = $val->validated('originaltitle');
				$movie->trailer_url = $val->validated('trailer_url');
				$movie->file_id = $val->validated('file_id');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('movie', $movie, false);
		}

		$this->template->title = "Movies";
		$this->template->content = View::forge('admin/movies/edit');
	}

	public function action_delete($id = null)
	{
		if ($movie = Model_Movie::find($id))
		{
			$movie->delete();

			Session::set_flash('success', 'Deleted movie #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete movie #' . $id);
		}

		Response::redirect('admin/movies');
	}

}