<?php
class Controller_Admin_Producers extends Controller_Admin 
{

	public function action_index()
	{
		$data['producers'] = Model_Producer::find('all');
		$this->template->title = "Producers";
		$this->template->content = View::forge('admin/producers/index', $data);

	}

	public function action_view($id = null)
	{
		$data['producer'] = Model_Producer::find($id);

		$this->template->title = "Producers";
		$this->template->content = View::forge('admin/producers/view', $data);

	}

	public function action_create()
	{
                $view = View::forge('admin/producers/create');
            
		if (Input::method() == 'POST')
		{
			$val = Model_Producer::validate('create');
			
			if ($val->run())
			{
				$producer = Model_Producer::forge(array(
					'person_id' => Input::post('person_id'),
					'movie_id' => Input::post('movie_id'),
				));

				if ($producer and $producer->save())
				{
					Session::set_flash('success', 'Added producer #'.$producer->id.'.');

					Response::redirect('admin/producers');
				}

				else
				{
					Session::set_flash('error', 'Could not save producer.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

                $view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
                $view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
                
		$this->template->title = "Producers";
		$this->template->content = View::forge('admin/producers/create');

	}

	public function action_edit($id = null)
	{
                $view = View::forge('admin/producers/edit');
                
		$producer = Model_Producer::find($id);
		$val = Model_Producer::validate('edit');

		if ($val->run())
		{
			$producer->person_id = Input::post('person_id');
			$producer->movie_id = Input::post('movie_id');

			if ($producer->save())
			{
				Session::set_flash('success', 'Updated producer #' . $id);

				Response::redirect('admin/producers');
			}

			else
			{
				Session::set_flash('error', 'Could not update producer #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$producer->person_id = $val->validated('person_id');
				$producer->movie_id = $val->validated('movie_id');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('producer', $producer, false);
		}
                
                $view->set_global('people', Arr::assoc_to_keyval(Model_Person::find('all'), 'id', 'name'));
                $view->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
                
		$this->template->title = "Producers";
		$this->template->content = View::forge('admin/producers/edit');

	}

	public function action_delete($id = null)
	{
		if ($producer = Model_Producer::find($id))
		{
			$producer->delete();

			Session::set_flash('success', 'Deleted producer #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete producer #'.$id);
		}

		Response::redirect('admin/producers');

	}


}