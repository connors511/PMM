<?php

class Controller_Admin_Directors extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/directors'), 3, Model_Director::find()->count());
		$data['directors'] = Model_Director::find('all', array(
			    'related' => array(
				'person',
				'movie'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Directors";
		$this->template->content = View::forge('admin/directors/index', $data);
	}

	public function action_view($id = null)
	{
		$data['director'] = Model_Director::find($id);

		$this->template->title = "Director";
		$this->template->content = View::forge('admin/directors/view', $data);
	}

	public function action_create()
	{
		$view = View::forge('admin/directors/create');

		if (Input::method() == 'POST')
		{
			$val = Model_Director::validate('create');

			if ($val->run())
			{
				$director = Model_Director::forge(array(
					    'person_id' => Input::post('person_id'),
					    'movie_id' => Input::post('movie_id'),
					));

				if ($director and $director->save())
				{
					Session::set_flash('success', 'Added director #' . $director->id . '.');

					Response::redirect('admin/directors');
				}
				else
				{
					Session::set_flash('error', 'Could not save director.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
		$view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));

		$this->template->title = "Directors";
		$this->template->content = View::forge('admin/directors/create');
	}

	public function action_edit($id = null)
	{
		$view = View::forge('admin/directors/edit');

		$director = Model_Director::find($id);
		$val = Model_Director::validate('edit');

		if ($val->run())
		{
			$director->person_id = Input::post('person_id');
			$director->movie_id = Input::post('movie_id');

			if ($director->save())
			{
				Session::set_flash('success', 'Updated director #' . $id);

				Response::redirect('admin/directors');
			}
			else
			{
				Session::set_flash('error', 'Could not update director #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$director->person_id = $val->validated('person_id');
				$director->movie_id = $val->validated('movie_id');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('director', $director, false);
		}

		$view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
		$view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));

		$this->template->title = "Directors";
		$this->template->content = View::forge('admin/directors/edit');
	}

	public function action_delete($id = null)
	{
		if ($director = Model_Director::find($id))
		{
			$director->delete();

			Session::set_flash('success', 'Deleted director #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete director #' . $id);
		}

		Response::redirect('admin/directors');
	}

}