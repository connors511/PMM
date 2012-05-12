<?php

class Controller_Admin extends Controller_Base {

	public $template = 'admin/template';

	public function before()
	{
		parent::before();

		if ( ! Auth::member(100) and Request::active()->action != 'login')
		{
			Response::redirect('admin/login');
		}
	}

	public function action_login()
	{
		// Already logged in
		Auth::check() and Response::redirect('admin');

		$val = Validation::forge();

		if (Input::method() == 'POST')
		{
			$val->add('email', 'Email or Username')
			    ->add_rule('required');
			$val->add('password', 'Password')
			    ->add_rule('required');

			if ($val->run())
			{
				$auth = Auth::instance();

				// check the credentials. This assumes that you have the previous table created
				if (Auth::check() or $auth->login(Input::post('email'), Input::post('password')))
				{
					// credentials ok, go right in
					Session::set_flash('notice', 'Welcome, '.$current_user->username);
					Response::redirect('admin');
				}
				else
				{
					$this->template->set_global('login_error', 'Fail');
				}
			}
		}

		$this->template->title = 'Login';
		$this->template->content = View::forge('admin/login', array('val' => $val));
	}

	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_logout()
	{
		Auth::logout();
		Response::redirect('admin');
	}

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		$sources = Model_Source::find('all');
		View::set_global('sources',$sources);
		
		$images = Model_Image::find()->count();
		View::set_global('images',$images);
		
		$movies = Model_Movie::find()->count();
		View::set_global('movies',$movies);
		
		$files = Model_File::find()->count();
		View::set_global('files',$files);
		
		$subtitles = Model_Subtitle::find()->count();
		View::set_global('subtitles',$subtitles);
		
		$people = Model_Person::find()->count();
		View::set_global('people',$people);
		
		$actors = Model_Actor::find()->count();
		View::set_global('actors',$actors);
		
		$directors = Model_Director::find()->count();
		View::set_global('directors',$directors);
		
		$this->template->title = 'Dashboard';
		$this->template->content = View::forge('admin/dashboard');
	}
	
	public function action_scan($id)
	{
	        $path = Model_Source::find($id);
		if ($path == null) {
		    Session::set_flash('error', 'Invalid path ID');
		}
		
		$scanner = new Scanner_Movie($path);
		$scanner->scan();
		
		$inserts = $scanner->get_and_reset_inserts();
		
		Session::set_flash('success','Scanned ' . count($inserts) . ' movies.');
		
		//Response::redirect('admin');
	}
	
	public function action_truncate()
	{
		\DBUtil::truncate_table('actors');
		\DBUtil::truncate_table('directors');
		\DBUtil::truncate_table('files');
		\DBUtil::truncate_table('genres');
		\DBUtil::truncate_table('genres_movies');
		\DBUtil::truncate_table('images');
		
		\DBUtil::truncate_table('movies');
		\DBUtil::truncate_table('people');
		\DBUtil::truncate_table('producers');
		\DBUtil::truncate_table('subtitles');
		
		\File::delete_dir(DOCROOT.'assets/img/cache',true,false);
		Response::redirect('admin');
	}

}

/* End of file admin.php */
