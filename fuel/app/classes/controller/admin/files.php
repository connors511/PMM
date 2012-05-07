<?php

class Controller_Admin_Files extends Controller_Admin
{

	public function action_index()
	{
		Pagination::set_config(array(
		    'pagination_url' => Uri::create('admin/files'),
		    'uri_segment' => 3,
		    'total_items' => Model_File::find()->count(),
		    'per_page' => 20,
		    'template' => array(
			'wrapper_start' => '<div class="pagination"> ',
			'wrapper_end' => ' </div>',
		    ),
		));
		$data['files'] = Model_File::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));

		$this->template->title = "Files";
		$this->template->content = View::forge('admin/files/index', $data);
	}

	public function action_view($id = null)
	{
		$data['file'] = Model_File::find($id);

		$this->template->title = "File";
		$this->template->content = View::forge('admin/files/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_File::validate('create');

			if ($val->run())
			{
				$file = Model_File::forge(array(
					    'path' => Input::post('path'),
					    'source_id' => Input::post('source_id'),
					));

				if ($file and $file->save())
				{
					Session::set_flash('success', 'Added file #' . $file->id . '.');

					Response::redirect('admin/files');
				}
				else
				{
					Session::set_flash('error', 'Could not save file.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Files";
		$this->template->content = View::forge('admin/files/create');
	}

	public function action_edit($id = null)
	{
		$file = Model_File::find($id);
		$val = Model_File::validate('edit');

		if ($val->run())
		{
			$file->path = Input::post('path');
			$file->source_id = Input::post('source_id');

			if ($file->save())
			{
				Session::set_flash('success', 'Updated file #' . $id);

				Response::redirect('admin/files');
			}
			else
			{
				Session::set_flash('error', 'Could not update file #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$file->path = $val->validated('path');
				$file->source_id = $val->validated('source_id');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('file', $file, false);
		}

		$this->template->title = "Files";
		$this->template->content = View::forge('admin/files/edit');
	}

	public function action_delete($id = null)
	{
		if ($file = Model_File::find($id))
		{
			$file->delete();

			Session::set_flash('success', 'Deleted file #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete file #' . $id);
		}

		Response::redirect('admin/files');
	}

}