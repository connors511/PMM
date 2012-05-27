<?php

class Controller_Admin_Images extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/images'), 3, Model_Image::find()->count());
		$data['images'] = Model_Image::find('all', array(
			    'related' => array(
				'movie'
			    ),
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));

		//$data['images'] = Model_Image::find()->related('movie')->get();
		$this->template->title = "Images";
		$this->template->content = View::forge('admin/images/index', $data);
	}

	public function action_view($id = null)
	{
		$data['image'] = Model_Image::find($id, array(
			    'related' => array(
				'movie'
			    )
			));

		$this->template->title = "Image";
		$this->template->content = View::forge('admin/images/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Image::validate('create');

			if ($val->run())
			{
				$image = Model_Image::forge(array(
					    'file_id' => Input::post('file_id'),
					    'height' => Input::post('height'),
					    'width' => Input::post('width'),
					    'movie_id' => Input::post('movie_id')
					));

				if ($image and $image->save())
				{
					Session::set_flash('success', 'Added image #' . $image->id . '.');

					Response::redirect('admin/images');
				}
				else
				{
					Session::set_flash('error', 'Could not save image.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
		$this->template->title = "Images";
		$this->template->content = View::forge('admin/images/create');
	}

	public function action_edit($id = null)
	{
		$image = Model_Image::find($id);
		$val = Model_Image::validate('edit');

		if ($val->run())
		{
			$image->file_id = Input::post('file_id');
			$image->height = Input::post('height');
			$image->width = Input::post('width');
			$image->movie_id = Input::post('movie_id');

			if ($image->save())
			{
				Session::set_flash('success', 'Updated image #' . $id);

				Response::redirect('admin/images');
			}
			else
			{
				Session::set_flash('error', 'Could not update image #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$image->file_id = $val->validated('file_id');
				$image->height = $val->validated('height');
				$image->width = $val->validated('width');
				$image->movie_id = $val->validated('movie_id');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('image', $image, false);
		}

		$this->template->set_global('movies', Arr::assoc_to_keyval(Model_Movie::find('all'), 'id', 'title'));
		$this->template->title = "Images";
		$this->template->content = View::forge('admin/images/edit');
	}

	public function action_delete($id = null)
	{
		if ($image = Model_Image::find($id))
		{
			$image->delete();

			Session::set_flash('success', 'Deleted image #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete image #' . $id);
		}

		Response::redirect('admin/images');
	}

}