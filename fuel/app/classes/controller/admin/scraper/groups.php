<?php

class Controller_Admin_Scraper_Groups extends Controller_Admin
{

	public function action_index()
	{
		$this->set_pagination(Uri::create('admin/scraper/groups'), 4, Model_Scraper_Group::find()->count());
		$data['scraper_groups'] = Model_Scraper_Group::find('all', array(
			    'limit' => \Fuel\Core\Pagination::$per_page,
			    'offset' => \Fuel\Core\Pagination::$offset
			));
		$this->template->title = "Scraper_groups";
		$this->template->content = View::forge('admin/scraper/groups/index', $data);
	}

	public function action_view($id = null)
	{
		$data['scraper_group'] = Model_Scraper_Group::find($id);

		$this->template->title = "Scraper_group";
		$this->template->content = View::forge('admin/scraper/groups/view', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Scraper_Group::validate('create');

			if ($val->run())
			{
				$scraper_group = Model_Scraper_Group::forge(array(
					    'name' => Input::post('name'),
					    'scraper_type_id' => Input::post('scraper_type_id'),
					    'comment' => Input::post('comment'),
					));
				// Scraper fields
				$type = Model_Scraper_Type::find(Input::post('scraper_type_id'));
				if ($type == null)
				{
					Session::set_flash('error', 'Could not save scraper_group.');
				}
				else
				{
					$fields = Input::post($type->type);
					foreach ($fields as $k => $field)
					{
						if ($field == 0)
						{
							continue;
						}
						$sgf = new Model_Scraper_Group_Field();
						$sgf->scraper = Model_Scraper::find('first', array(
							    'where' => array(
								array('id', '=', $field)
							    )
							));
						$sgf->scraper_field = Model_Scraper_Field::find('first', array(
							    'where' => array(
								array('field', '=', $k)
							    )
							));
						$sgf->scraper_group = $scraper_group;
						$sgf->save();
					}
				}

				if ($scraper_group and $scraper_group->save())
				{
					Session::set_flash('success', 'Added scraper_group #' . $scraper_group->id . '.');

					Response::redirect('admin/scraper/groups');
				}
				else
				{
					Session::set_flash('error', 'Could not save scraper_group.');
				}
			}
			else
			{
				Session::set_flash('error', $val->show_errors());
			}
		}

		$types = Model_Scraper_Type::find('all', array(
			    'related' => array(
				'scraper_fields' => array(
				    'related' => array(
					'scrapers'
				    )
				)
			    )
			));

		$this->template->set_global('types', $types);

		$this->template->title = "Scraper_Groups";
		$this->template->content = View::forge('admin/scraper/groups/create');
	}

	public function action_edit($id = null)
	{
		$scraper_group = Model_Scraper_Group::find($id);
		$val = Model_Scraper_Group::validate('edit');

		if ($val->run())
		{
			$scraper_group->name = Input::post('name');
			$scraper_group->scraper_type_id = Input::post('scraper_type_id');
			$scraper_group->comment = Input::post('comment');

			// Scraper fields
			$type = Model_Scraper_Type::find(Input::post('scraper_type_id'));
			if ($type == null)
			{
				Session::set_flash('error', 'Could not save scraper_group.');
			}
			else
			{
				$fields = Model_Scraper_Field::find('all', array(
					    'where' => array(
						array('field', 'IN', array_keys(Input::post($type->type)))
					    )
					));
				
				// Remove group fields that are not in the current type
				$tmp = array();
				foreach($fields as $f)
				{
					$tmp[] = $f->id;
				}
				$remove = Model_Scraper_Group_Field::find('all', array(
				    'where' => array(
					array('scraper_group_id','=',$scraper_group->id),
					array('scraper_field_id','NOT IN',$tmp)
				    )
				));
				foreach($remove as $r)
				{
					$r->delete();
				}
				
				
				$status = Input::post($type->type);
				foreach ($fields as $field)
				{
					$sgf = Model_Scraper_Group_Field::find('first', array(
						    'where' => array(
							array('scraper_group_id', '=', $scraper_group->id),
							array('scraper_field_id', '=', $field->id)
						    )
						));
					if ($sgf)
					{
						if ($status[$field->field] == 0)
						{
							// Remove it
							$sgf->delete();
						}
						else
						{
							// Do we need an update?
							if ($sgf->scraper_id != $status[$field->field])
							{
								$sgf->scraper_id = $status[$field->field];
								$sgf->save();
							}
						}
					}
					elseif ($status[$field->field] != 0)
					{
						// Create it
						$sgf = new Model_Scraper_Group_Field();
						$sgf->scraper = Model_Scraper::find('first', array(
							    'where' => array(
								array('id', '=', $status[$field->field])
							    )
							));
						$sgf->scraper_field = $field;
						$sgf->scraper_group = $scraper_group;
						$sgf->save();
					}
				}
			}
			if ($scraper_group->save())
			{
				Session::set_flash('success', 'Updated scraper_group #' . $id);

				Response::redirect('admin/scraper/groups');
			}
			else
			{
				Session::set_flash('error', 'Could not update scraper_group #' . $id);
			}
		}
		else
		{
			if (Input::method() == 'POST')
			{
				$scraper_group->name = $val->validated('name');
				$scraper_group->scraper_type_id = $val->validated('scraper_type_id');
				$scraper_group->comment = $val->validated('comment');

				Session::set_flash('error', $val->show_errors());
			}

			$this->template->set_global('scraper_group', $scraper_group, false);
		}

		$types = Model_Scraper_Type::find('all', array(
			    'related' => array(
				'scraper_fields' => array(
				    'related' => array(
					'scrapers'
				    )
				)
			    )
			));

		$this->template->set_global('types', $types);

		$this->template->title = "Scraper_groups";
		$this->template->content = View::forge('admin/scraper/groups/edit');
	}

	public function action_delete($id = null)
	{
		if ($scraper_group = Model_Scraper_Group::find($id))
		{
			$scraper_group->delete();

			Session::set_flash('success', 'Deleted scraper_group #' . $id);
		}
		else
		{
			Session::set_flash('error', 'Could not delete scraper_group #' . $id);
		}

		Response::redirect('admin/scraper/groups');
	}

}