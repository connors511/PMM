<?php

class Controller_Admin_Sources extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/sources'), 3, Model_Source::find()->count());
		$data['sources'] = Model_Source::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Sources";
		$this->template->content = View::forge('admin/sources/index', $data);
	}

	public function action_view($id = null)
	{
		$data['source'] = Model_Source::find($id);

		$this->template->title = "Source";
		$this->template->content = View::forge('admin/source/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Source::validate('create');

			if ($val->run())
			{
				$source = Model_Source::forge(array(
					    'path' => Input::post('path'),
					    'scrapergroup' => Input::post('scrapergroup'),
					));

				if ($source and $source->save())
				{
					Session::set_flash('success', 'Added source #' . $source->id . '.');

					Response::redirect('admin/sources');
				}
				else
				{
					Session::set_flash('error', 'Could not save source.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Paths";
		$this->template->content = View::forge('admin/sources/create');
	}

	public function action_edit($id = null)
	{
		$source = Model_Source::find($id);
		$val = Model_Source::validate('edit');

		if ($val->run())
		{
			$source->path = Input::post('path');
			$source->scrapergroup = Input::post('scrapergroup');

			if ($source->save())
			{
				Session::set_flash('success', 'Updated source #' . $id);

				Response::redirect('admin/sources');
			}
			else
			{
				Session::set_flash('error', 'Could not update source #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$source->path = $val->validated('path');
				$source->scrapergroup = $val->validated('scrapergroup');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('source', $source, false);
		}

		$this->template->title = "Paths";
		$this->template->content = View::forge('admin/sources/edit');
	}

	public function action_delete($id = null)
	{
		if ($source = Model_Source::find($id))
		{
			$source->delete();

			Session::set_flash('success', 'Deleted source #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete source #' . $id);
		}

		Response::redirect('admin/sources');
	}

}