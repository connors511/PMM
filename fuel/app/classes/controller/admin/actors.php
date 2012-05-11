<?php
class Controller_Admin_Actors extends Controller_Admin 
{

	public function action_index()
	{
		$data['actors'] = Model_Actor::find('all', array(
			    'related' => array(
				'person',
				'movie'
			    )
			));
		$this->template->title = "Actors";
		$this->template->content = View::forge('admin/actors/index', $data);

	}

	public function action_view($id = null)
	{
		$data['actor'] = Model_Actor::find($id);

		$this->template->title = "Actor";
		$this->template->content = View::forge('admin/actors/view', $data);

	}

	public function action_create()
	{
                $view = View::forge('admin/actors/create');
                
		if (Input::method() == 'POST')
		{
			$val = Model_Actor::validate('create');
			
			if ($val->run())
			{
				$actor = Model_Actor::forge(array(
					'person_id' => Input::post('person_id'),
					'movie_id' => Input::post('movie_id'),
					'role' => Input::post('role'),
				));

				if ($actor and $actor->save())
				{
					Session::set_flash('success', 'Added actor #'.$actor->id.'.');

					Response::redirect('admin/actors');
				}

				else
				{
					Session::set_flash('error', 'Could not save actor.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

                $view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
                $view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
                
		$this->template->title = "Actors";
		$this->template->content = View::forge('admin/actors/create');

	}

	public function action_edit($id = null)
	{
                $view = View::forge('admin/actors/edit');
                
		$actor = Model_Actor::find($id);
		$val = Model_Actor::validate('edit');

		if ($val->run())
		{
			$actor->person_id = Input::post('person_id');
			$actor->movie_id = Input::post('movie_id');
			$actor->role = Input::post('role');

			if ($actor->save())
			{
				Session::set_flash('success', 'Updated actor #' . $id);

				Response::redirect('admin/actors');
			}

			else
			{
				Session::set_flash('error', 'Could not update actor #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$actor->person_id = $val->validated('person_id');
				$actor->movie_id = $val->validated('movie_id');
				$actor->role = $val->validated('role');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('actor', $actor, false);
		}

                $view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
                $view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
                
		$this->template->title = "Actors";
		$this->template->content = View::forge('admin/actors/edit');

	}

	public function action_delete($id = null)
	{
		if ($actor = Model_Actor::find($id))
		{
			$actor->delete();

			Session::set_flash('success', 'Deleted actor #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete actor #'.$id);
		}

		Response::redirect('admin/actors');

	}


}