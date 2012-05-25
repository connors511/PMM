<?php
class Controller_Admin_Scraper_Fields extends Controller_Admin 
{

	public function action_index()
	{
		$data['scraper_fields'] = Model_Scraper_Field::find('all', array(
		    'related' => array(
			'scraper_type'
		    )
		));
		$this->template->title = "Scraper_fields";
		$this->template->content = View::forge('admin/scraper/fields/index', $data);

	}

	public function action_view($id = null)
	{
		$data['scraper_field'] = Model_Scraper_Field::find($id);

		$this->template->title = "Scraper_field";
		$this->template->content = View::forge('admin/scraper/fields/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Scraper_Field::validate('create');
			
			if ($val->run())
			{
				$scraper_field = Model_Scraper_Field::forge(array(
					'field' => Input::post('field'),
					'scraper_type_id' => Input::post('type'),
				));

				if ($scraper_field and $scraper_field->save())
				{
					Session::set_flash('success', 'Added scraper_field #'.$scraper_field->id.'.');

					Response::redirect('admin/scraper/fields');
				}

				else
				{
					Session::set_flash('error', 'Could not save scraper_field.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Scraper_Fields";
		$this->template->content = View::forge('admin/scraper/fields/create');

	}

	public function action_edit($id = null)
	{
		$scraper_field = Model_Scraper_Field::find($id);
		$val = Model_Scraper_Field::validate('edit');

		if ($val->run())
		{
			$scraper_field->field = Input::post('field');
			$scraper_field->scraper_type_id = Input::post('type');

			if ($scraper_field->save())
			{
				Session::set_flash('success', 'Updated scraper_field #' . $id);

				Response::redirect('admin/scraper/fields');
			}

			else
			{
				Session::set_flash('error', 'Could not update scraper_field #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$scraper_field->field = $val->validated('field');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('scraper_field', $scraper_field, false);
		}

		$this->template->title = "Scraper_fields";
		$this->template->content = View::forge('admin/scraper/fields/edit');

	}

	public function action_delete($id = null)
	{
		if ($scraper_field = Model_Scraper_Field::find($id))
		{
			$scraper_field->delete();

			Session::set_flash('success', 'Deleted scraper_field #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete scraper_field #'.$id);
		}

		Response::redirect('admin/scraper/fields');

	}


}