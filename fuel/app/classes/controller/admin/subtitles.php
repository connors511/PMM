<?php

class Controller_Admin_Subtitles extends Controller_Admin
{

	public function action_index()
	{
		$data['subtitles'] = Model_Subtitle::find('all', array(
			    'related' => array(
				'file',
				'movie'
			    )
			));
		$this->template->title = "Subtitles";
		$this->template->content = View::forge('admin/subtitles/index', $data);
	}

	public function action_view($id = null)
	{
		$data['subtitle'] = Model_Subtitle::find($id);

		$this->template->title = "Subtitle";
		$this->template->content = View::forge('admin/subtitles/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Subtitle::validate('create');

			if ($val->run())
			{
				$subtitle = Model_Subtitle::forge(array(
					    'file_id' => Input::post('file_id'),
					    'language' => Input::post('language'),
					    'movie_id' => Input::post('movie_id'),
					));

				if ($subtitle and $subtitle->save())
				{
					Session::set_flash('success', 'Added subtitle #' . $subtitle->id . '.');

					Response::redirect('admin/subtitles');
				}
				else
				{
					Session::set_flash('error', 'Could not save subtitle.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Subtitles";
		$this->template->content = View::forge('admin/subtitles/create');
	}

	public function action_edit($id = null)
	{
		$subtitle = Model_Subtitle::find($id);
		$val = Model_Subtitle::validate('edit');

		if ($val->run())
		{
			$subtitle->file_id = Input::post('file_id');
			$subtitle->language = Input::post('language');
			$subtitle->movie_id = Input::post('movie_id');

			if ($subtitle->save())
			{
				Session::set_flash('success', 'Updated subtitle #' . $id);

				Response::redirect('admin/subtitles');
			}
			else
			{
				Session::set_flash('error', 'Could not update subtitle #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$subtitle->file_id = $val->validated('file_id');
				$subtitle->language = $val->validated('language');
				$subtitle->movie_id = $val->validated('movie_id');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('subtitle', $subtitle, false);
		}

		$this->template->title = "Subtitles";
		$this->template->content = View::forge('admin/subtitles/edit');
	}

	public function action_delete($id = null)
	{
		if ($subtitle = Model_Subtitle::find($id))
		{
			$subtitle->delete();

			Session::set_flash('success', 'Deleted subtitle #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete subtitle #' . $id);
		}

		Response::redirect('admin/subtitles');
	}

}