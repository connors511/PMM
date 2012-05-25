<?php
class Controller_Admin_Scraper_Types extends Controller_Admin 
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/scraper/types'), 4, Model_Scraper_Type::find()->count());
		$data['scraper_types'] = Model_Scraper_Type::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Scraper_types";
		$this->template->content = View::forge('admin/scraper/types/index', $data);

	}

	public function action_view($id = null)
	{
		$data['scraper_type'] = Model_Scraper_Type::find($id);

		$this->template->title = "Scraper_type";
		$this->template->content = View::forge('admin/scraper/types/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Scraper_Type::validate('create');
			
			if ($val->run())
			{
				$scraper_type = Model_Scraper_Type::forge(array(
					'type' => Input::post('type'),
				));

				if ($scraper_type and $scraper_type->save())
				{
					Session::set_flash('success', 'Added scraper_type #'.$scraper_type->id.'.');

					Response::redirect('admin/scraper/types');
				}

				else
				{
					Session::set_flash('error', 'Could not save scraper_type.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Scraper_Types";
		$this->template->content = View::forge('admin/scraper/types/create');

	}

	public function action_edit($id = null)
	{
		$scraper_type = Model_Scraper_Type::find($id);
		$val = Model_Scraper_Type::validate('edit');

		if ($val->run())
		{
			$scraper_type->type = Input::post('type');

			if ($scraper_type->save())
			{
				Session::set_flash('success', 'Updated scraper_type #' . $id);

				Response::redirect('admin/scraper/types');
			}

			else
			{
				Session::set_flash('error', 'Could not update scraper_type #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$scraper_type->type = $val->validated('type');

				Session::set_flash('error', $val->show_errors());
			}
			
			$this->template->set_global('scraper_type', $scraper_type, false);
		}

		$this->template->title = "Scraper_types";
		$this->template->content = View::forge('admin/scraper/types/edit');

	}

	public function action_delete($id = null)
	{
		if ($scraper_type = Model_Scraper_Type::find($id))
		{
			$scraper_type->delete();

			Session::set_flash('success', 'Deleted scraper_type #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete scraper_type #'.$id);
		}

		Response::redirect('admin/scraper/types');

	}


}