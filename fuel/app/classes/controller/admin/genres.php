<?php
class Controller_Admin_Genres extends Controller_Admin 
{

	public function action_index()
	{
		$data['genres'] = Model_Genre::find('all', array(
		    'related' => array(
			'movies'
		    )
		));
		$this->template->title = "Genres";
		$this->template->content = View::forge('admin/genres/index', $data);

	}

	public function action_view($id = null)
	{
		$data['genre'] = Model_Genre::find($id);
		$this->template->title = "Genre";
		$this->template->content = View::forge('admin/genres/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Genre::validate('create');
			
			if ($val->run())
			{
				$genre = Model_Genre::forge(array(
					'name' => Input::post('name'),
				));

				if ($genre and $genre->save())
				{
					Session::set_flash('success', 'Added genre #'.$genre->id.'.');

					Response::redirect('admin/genres');
				}

				else
				{
					Session::set_flash('error', 'Could not save genre.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Genres";
		$this->template->content = View::forge('admin/genres/create');

	}

	public function action_edit($id = null)
	{
		$genre = Model_Genre::find($id);
		$val = Model_Genre::validate('edit');

		if ($val->run())
		{
			$genre->name = Input::post('name');

			if ($genre->save())
			{
				Session::set_flash('success', 'Updated genre #' . $id);

				Response::redirect('admin/genres');
			}

			else
			{
				Session::set_flash('error', 'Could not update genre #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$genre->name = $val->validated('name');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('genre', $genre, false);
		}

		$this->template->title = "Genres";
		$this->template->content = View::forge('admin/genres/edit');

	}

	public function action_delete($id = null)
	{
		if ($genre = Model_Genre::find($id))
		{
			$genre->delete();

			Session::set_flash('success', 'Deleted genre #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete genre #'.$id);
		}

		Response::redirect('admin/genres');

	}


}