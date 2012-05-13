<?php

class Controller_Admin_Scrapers extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/scrapers'), 3, Model_Scraper::find()->count());
		$data['scrapers'] = Model_Scraper::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Scrapers";
		$this->template->content = View::forge('admin/scrapers/index', $data);
	}

	public function action_view($id = null)
	{
		$data['scraper'] = Model_Scraper::find($id);

		$this->template->title = "Scraper";
		$this->template->content = View::forge('admin/scrapers/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Scraper::validate('create');

			if ($val->run())
			{
				$scraper = Model_Scraper::forge(array(
					    'name' => Input::post('name'),
					    'author' => Input::post('author'),
					    'type' => Input::post('type'),
					    'version' => Input::post('version'),
					    'fields' => Input::post('fields'),
					));

				if ($scraper and $scraper->save())
				{
					Session::set_flash('success', 'Added scraper #' . $scraper->id . '.');

					Response::redirect('admin/scrapers');
				}
				else
				{
					Session::set_flash('error', 'Could not save scraper.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$this->template->title = "Scrapers";
		$this->template->content = View::forge('admin/scrapers/create');
	}

	public function action_edit($id = null)
	{
		$scraper = Model_Scraper::find($id);
		$val = Model_Scraper::validate('edit');

		if ($val->run())
		{
			$scraper->name = Input::post('name');
			$scraper->author = Input::post('author');
			$scraper->type = Input::post('type');
			$scraper->version = Input::post('version');
			$scraper->fields = Input::post('fields');

			if ($scraper->save())
			{
				Session::set_flash('success', 'Updated scraper #' . $id);

				Response::redirect('admin/scrapers');
			}
			else
			{
				Session::set_flash('error', 'Could not update scraper #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$scraper->name = $val->validated('name');
				$scraper->author = $val->validated('author');
				$scraper->type = $val->validated('type');
				$scraper->version = $val->validated('version');
				$scraper->fields = $val->validated('fields');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('scraper', $scraper, false);
		}

		$this->template->title = "Scrapers";
		$this->template->content = View::forge('admin/scrapers/edit');
	}

	public function action_delete($id = null)
	{
		if ($scraper = Model_Scraper::find($id))
		{
			$scraper->delete();

			Session::set_flash('success', 'Deleted scraper #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete scraper #' . $id);
		}

		Response::redirect('admin/scrapers');
	}

	public function action_scanscrapers()
	{
		$stats = array('new' => 0, 'updated' => 0, 'existing' => 0);
		$files = File::read_dir(APPPATH . 'classes/scraper');
		foreach ($files as $file)
		{
			$info = File::file_info(APPPATH . 'classes/scraper/' . $file);
			$class = 'Scraper_' . ucfirst($info['filename']);
			$scanner = new $class();
			$tmp = Model_Scraper::find('first', array(
				    'where' => array(
					array('name', '=', $scanner->get_name())
				    )
				));
			if ($tmp == null)
			{
				$tmp = new Model_Scraper();
				$tmp->name = $scanner->get_name();
				$tmp->author = $scanner->get_author();
				$tmp->type = $scanner->get_type();
				$tmp->version = $scanner->get_version();
				$tmp->fields = $scanner->get_supported_fields();
				$stats['new']++;
			}
			else
			{
				if ($tmp->version < $scanner->get_version())
				{
					// Update version
					// Author and fields could've changed
					$tmp->author = $scanner->get_author();
					$tmp->type = $scanner->get_type();
					$tmp->version = $scanner->get_version();
					$tmp->fields = $scanner->get_supported_fields();
					$stats['updated']++;
				}
				else
				{
					$stats['existing']++;
				}
			}
			$tmp->save();
		}

		Session::set_flash('success', 'Added ' . $stats['new'] . ', updated ' . $stats['updated'] . ' and found ' . $stats['existing'] . ' existing scrapers.');

		Response::redirect('admin/scrapers');
	}

}