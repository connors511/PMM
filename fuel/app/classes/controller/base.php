<?php

class Controller_Base extends Controller_Template
{

	public function before()
	{
		parent::before();

		// Assign current_user to the instance so controllers can use it
		$this->current_user = Auth::check() ? Model_User::find_by_username(Auth::get_screen_name()) : null;

		// Set a global variable so views can use it
		View::set_global('current_user', $this->current_user);
	}

	public function set_pagination($url, $segment, $total_items, $per_page = 20)
	{
		Pagination::set_config(array(
		    'pagination_url' => $url,
		    'uri_segment' => $segment,
		    'total_items' => $total_items,
		    'per_page' => $per_page,
		    'template' => array(
			'wrapper_start' => '<div class="pagination"> ',
			'wrapper_end' => ' </div>',
		    ),
		));
	}

}