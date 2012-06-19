<?php
class Controller_Admin_Stream_Audio extends Controller_Admin 
{

	public function action_index()
	{
		$data['stream_audios'] = Model_Stream_Audio::find('all');
		$this->template->title = "Audio streams";
		$this->template->content = View::forge('admin/stream/audio/index', $data);

	}

	public function action_view($id = null)
	{
		$data['stream_audio'] = Model_Stream_Audio::find($id);

		$this->template->title = "Audio stream";
		$this->template->content = View::forge('admin/stream/audio/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Stream_Audio::validate('create');
			
			if ($val->run())
			{
				$stream_audio = Model_Stream_Audio::forge(array(
					'bitrate' => Input::post('bitrate'),
					'samplerate' => Input::post('samplerate'),
					'codec' => Input::post('codec'),
					'channels' => Input::post('channels'),
					'language' => Input::post('language'),
					'movie_id' => Input::post('movie_id')
				));

				if ($stream_audio and $stream_audio->save())
				{
					Session::set_flash('success', 'Added audio stream #'.$stream_audio->id.'.');

					Response::redirect('admin/stream/audio');
				}

				else
				{
					Session::set_flash('error', 'Could not save audio stream.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}
		$groups = Model_Movie::find('all');
		$this->template->set_global('movies', Arr::assoc_to_keyval($groups,'id','title'));
		
		$this->template->title = "Audio streams";
		$this->template->content = View::forge('admin/stream/audio/create');

	}

	public function action_edit($id = null)
	{
		$stream_audio = Model_Stream_Audio::find($id);
		$val = Model_Stream_Audio::validate('edit');

		if ($val->run())
		{
			$stream_audio->bitrate = Input::post('bitrate');
			$stream_audio->samplerate = Input::post('samplerate');
			$stream_audio->codec = Input::post('codec');
			$stream_audio->channels = Input::post('channels');
			$stream_audio->language = Input::post('language');
			$stream_audio->movie_id = Input::post('movie_id');

			if ($stream_audio->save())
			{
				Session::set_flash('success', 'Updated audio stream #' . $id);

				Response::redirect('admin/stream/audio');
			}

			else
			{
				Session::set_flash('error', 'Could not update audio stream #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$stream_audio->bitrate = $val->validated('bitrate');
				$stream_audio->samplerate = $val->validated('samplerate');
				$stream_audio->codec = $val->validated('codec');
				$stream_audio->channels = $val->validated('channels');
				$stream_audio->language = $val->validated('language');
				$stream_audio->movie_id = $val->validated('movie_id');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('stream_audio', $stream_audio, false);
		}

		$groups = Model_Movie::find('all');
		$this->template->set_global('movies', Arr::assoc_to_keyval($groups,'id','title'));
		
		$this->template->title = "Audio streams";
		$this->template->content = View::forge('admin/stream/audio/edit');

	}

	public function action_delete($id = null)
	{
		if ($stream_audio = Model_Stream_Audio::find($id))
		{
			$stream_audio->delete();

			Session::set_flash('success', 'Deleted audio stream #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete audio stream #'.$id);
		}

		Response::redirect('admin/stream/audio');

	}


}