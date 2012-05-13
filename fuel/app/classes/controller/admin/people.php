<?php

class Controller_Admin_People extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/people'), 3, Model_Person::find()->count());
		$data['people'] = Model_Person::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "People";
		$this->template->content = View::forge('admin/people/index', $data);
	}

	public function action_view($id = null)
	{
		$data['person'] = Model_Person::find($id);

		$this->template->title = "Person";
		$this->template->content = View::forge('admin/people/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Person::validate('create');

			if ($val->run())
			{
				$person = Model_Person::forge(array(
					    'name' => Input::post('name'),
					    'biography' => Input::post('biography'),
					    'birthname' => Input::post('birthname'),
					    'birthday' => Input::post('birthday'),
					    'birthlocation' => Input::post('birthlocation'),
					    'height' => Input::post('height'),
					));

				if ($person and $person->save())
				{
					Session::set_flash('success', 'Added person #' . $person->id . '.');

					Response::redirect('admin/people');
				}
				else
				{
					Session::set_flash('error', 'Could not save person.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "People";
		$this->template->content = View::forge('admin/people/create');
	}

	public function action_edit($id = null)
	{
		$person = Model_Person::find($id);
		$val = Model_Person::validate('edit');

		if ($val->run())
		{
			$person->name = Input::post('name');
			$person->biography = Input::post('biography');
			$person->birthname = Input::post('birthname');
			$person->birthday = Input::post('birthday');
			$person->birthlocation = Input::post('birthlocation');
			$person->height = Input::post('height');

			if ($person->save())
			{
				Session::set_flash('success', 'Updated person #' . $id);

				Response::redirect('admin/people');
			}
			else
			{
				Session::set_flash('error', 'Could not update person #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$person->name = $val->validated('name');
				$person->biography = $val->validated('biography');
				$person->birthname = $val->validated('birthname');
				$person->birthday = $val->validated('birthday');
				$person->birthlocation = $val->validated('birthlocation');
				$person->height = $val->validated('height');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('person', $person, false);
		}

		$this->template->title = "People";
		$this->template->content = View::forge('admin/people/edit');
	}

	public function action_delete($id = null)
	{
		if ($person = Model_Person::find($id))
		{
			$person->delete();

			Session::set_flash('success', 'Deleted person #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete person #' . $id);
		}

		Response::redirect('admin/people');
	}

}