<?php
class Controller_Admin_Scrapergroup_Movie extends Controller_Admin 
{

	public function action_index()
	{
		$data['scrapergroup_movies'] = Model_Scrapergroup_Movie::find('all');
		$this->template->title = "Scrapergroup_movies";
		$this->template->content = View::forge('admin/scrapergroup/movie/index', $data);

	}

	public function action_view($id = null)
	{
		$data['scrapergroup_movie'] = Model_Scrapergroup_Movie::find($id);

		$this->template->title = "Scrapergroup_movie";
		$this->template->content = View::forge('admin/scrapergroup/movie/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Scrapergroup_Movie::validate('create');
			
			if ($val->run())
			{
				$scrapergroup_movie = Model_Scrapergroup_Movie::forge(array(
					'name' => Input::post('name'),
					'title' => Input::post('title'),
					'plot' => Input::post('plot'),
					'plotsummary' => Input::post('plotsummary'),
					'tagline' => Input::post('tagline'),
					'rating' => Input::post('rating'),
					'votes' => Input::post('votes'),
					'released' => Input::post('released'),
					'runtime' => Input::post('runtime'),
					'contentrating' => Input::post('contentrating'),
					'originaltitle' => Input::post('originaltitle'),
					'trailer_url' => Input::post('trailer_url'),
				));

				if ($scrapergroup_movie and $scrapergroup_movie->save())
				{
					Session::set_flash('success', 'Added scrapergroup_movie #'.$scrapergroup_movie->id.'.');

					Response::redirect('admin/scrapergroup/movie');
				}

				else
				{
					Session::set_flash('error', 'Could not save scrapergroup_movie.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Scrapergroup_Movies";
		$this->template->content = View::forge('admin/scrapergroup/movie/create');

	}

	public function action_edit($id = null)
	{
		$scrapergroup_movie = Model_Scrapergroup_Movie::find($id);
		$val = Model_Scrapergroup_Movie::validate('edit');

		if ($val->run())
		{
			$scrapergroup_movie->name = Input::post('name');
			$scrapergroup_movie->title = Input::post('title');
			$scrapergroup_movie->plot = Input::post('plot');
			$scrapergroup_movie->plotsummary = Input::post('plotsummary');
			$scrapergroup_movie->tagline = Input::post('tagline');
			$scrapergroup_movie->rating = Input::post('rating');
			$scrapergroup_movie->votes = Input::post('votes');
			$scrapergroup_movie->released = Input::post('released');
			$scrapergroup_movie->runtime = Input::post('runtime');
			$scrapergroup_movie->contentrating = Input::post('contentrating');
			$scrapergroup_movie->originaltitle = Input::post('originaltitle');
			$scrapergroup_movie->trailer_url = Input::post('trailer_url');

			if ($scrapergroup_movie->save())
			{
				Session::set_flash('success', 'Updated scrapergroup_movie #' . $id);

				Response::redirect('admin/scrapergroup/movie');
			}

			else
			{
				Session::set_flash('error', 'Could not update scrapergroup_movie #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$scrapergroup_movie->name = $val->validated('name');
				$scrapergroup_movie->title = $val->validated('title');
				$scrapergroup_movie->plot = $val->validated('plot');
				$scrapergroup_movie->plotsummary = $val->validated('plotsummary');
				$scrapergroup_movie->tagline = $val->validated('tagline');
				$scrapergroup_movie->rating = $val->validated('rating');
				$scrapergroup_movie->votes = $val->validated('votes');
				$scrapergroup_movie->released = $val->validated('released');
				$scrapergroup_movie->runtime = $val->validated('runtime');
				$scrapergroup_movie->contentrating = $val->validated('contentrating');
				$scrapergroup_movie->originaltitle = $val->validated('originaltitle');
				$scrapergroup_movie->trailer_url = $val->validated('trailer_url');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('scrapergroup_movie', $scrapergroup_movie, false);
		}

		$this->template->title = "Scrapergroup_movies";
		$this->template->content = View::forge('admin/scrapergroup/movie/edit');

	}

	public function action_delete($id = null)
	{
		if ($scrapergroup_movie = Model_Scrapergroup_Movie::find($id))
		{
			$scrapergroup_movie->delete();

			Session::set_flash('success', 'Deleted scrapergroup_movie #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete scrapergroup_movie #'.$id);
		}

		Response::redirect('admin/scrapergroup/movie');

	}


}