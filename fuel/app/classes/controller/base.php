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
			'wrapper_start' => '<ul class="pager">',
			'wrapper_end' => ' </ul>',
			'previous_inactive_start' => '<li class="previous disabled"><a href="javascript:void(0)">',
			'previous_inactive_end' => '</a></li>',
			'next_inactive_start' => '<li class="next disabled"><a href="javascript:void(0)">',
			'next_inactive_end' => '</a></li>',
			'previous_start' => '<li class="previous">',
			'previous_end' => '</li>',
			'next_start' => '<li class="next">',
			'next_end' => '</li>',
			'active_start' => ' <li class="active disabled"><a href="javascript:void(0)">',
			'active_end' => '</a></li> ',
			'regular_start' => ' ',
			'regular_end' => ' ',
		    ),
		));
	}

}