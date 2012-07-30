<?php
class Controller_Admin_Stream_Video extends Controller_Admin 
{

	public function action_index()
	{
		$data['stream_videos'] = Model_Stream_Video::find('all');
		$this->template->title = "Video streams";
		$this->template->content = View::forge('admin/stream/video/index', $data);

	}

	public function action_view($id = null)
	{
		$data['stream_video'] = Model_Stream_Video::find($id);

		$this->template->title = "Video stream";
		$this->template->content = View::forge('admin/stream/video/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Stream_Video::validate('create');
			
			if ($val->run())
			{
				$stream_video = Model_Stream_Video::forge(array(
					'duration' => Input::post('duration'),
					'frames' => Input::post('frames'),
					'fps' => Input::post('fps'),
					'height' => Input::post('height'),
					'width' => Input::post('width'),
					'pixelformat' => Input::post('pixelformat'),
					'bitrate' => Input::post('bitrate'),
					'codec' => Input::post('codec'),
					'movie_id' => Input::post('movie_id')
				));

				if ($stream_video and $stream_video->save())
				{
					Session::set_flash('success', 'Added video stream #'.$stream_video->id.'.');

					Response::redirect('admin/stream/video');
				}

				else
				{
					Session::set_flash('error', 'Could not save video stream.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}
		$groups = Model_Movie::find('all');
		$this->template->set_global('movies', Arr::assoc_to_keyval($groups,'id','title'));

		$this->template->title = "Video streams";
		$this->template->content = View::forge('admin/stream/video/create');

	}

	public function action_edit($id = null)
	{
		$stream_video = Model_Stream_Video::find($id);
		$val = Model_Stream_Video::validate('edit');

		if ($val->run())
		{
			$stream_video->duration = Input::post('duration');
			$stream_video->frames = Input::post('frames');
			$stream_video->fps = Input::post('fps');
			$stream_video->height = Input::post('height');
			$stream_video->width = Input::post('width');
			$stream_video->pixelformat = Input::post('pixelformat');
			$stream_video->bitrate = Input::post('bitrate');
			$stream_video->codec = Input::post('codec');
			$stream_video->movie_id = Input::post('movie_id');

			if ($stream_video->save())
			{
				Session::set_flash('success', 'Updated video stream #' . $id);

				Response::redirect('admin/stream/video');
			}

			else
			{
				Session::set_flash('error', 'Could not update video stream #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$stream_video->duration = $val->validated('duration');
				$stream_video->frames = $val->validated('frames');
				$stream_video->fps = $val->validated('fps');
				$stream_video->height = $val->validated('height');
				$stream_video->width = $val->validated('width');
				$stream_video->pixelformat = $val->validated('pixelformat');
				$stream_video->bitrate = $val->validated('bitrate');
				$stream_video->codec = $val->validated('codec');
				$stream_video->movie_id = $val->validated('codec');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('stream_video', $stream_video, false);
		}
		$groups = Model_Movie::find('all');
		$this->template->set_global('movies', Arr::assoc_to_keyval($groups,'id','title'));

		$this->template->title = "Video streams";
		$this->template->content = View::forge('admin/stream/video/edit');

	}

	public function action_delete($id = null)
	{
		if ($stream_video = Model_Stream_Video::find($id))
		{
			$stream_video->delete();

			Session::set_flash('success', 'Deleted video stream #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete video stream #'.$id);
		}

		Response::redirect('admin/stream/video');

	}


}