<?php

class Controller_Admin_Tools_Import extends Controller_Admin
{

	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = array();
		$data['sources'] = Model_Source::find('all');

		$sources = Model_Source::find('all');
		View::set_global('sources', $sources);

		$images = Model_Image::find()->count();
		View::set_global('images', $images);

		$movies = Model_Movie::find()->count();
		View::set_global('movies', $movies);

		$files = Model_File::find()->count();
		View::set_global('files', $files);

		$subtitles = Model_Subtitle::find()->count();
		View::set_global('subtitles', $subtitles);

		$people = Model_Person::find()->count();
		View::set_global('people', $people);

		$actors = Model_Actor::find()->count();
		View::set_global('actors', $actors);

		$directors = Model_Director::find()->count();
		View::set_global('directors', $directors);

		$producers = Model_Producer::find()->count();
		View::set_global('producers', $producers);

		$this->template->title = "Import";
		$this->template->content = View::forge('admin/tools/import/index', $data);
	}

	public function action_scan($id)
	{

		$path = Model_Source::find($id);

		if ($path == null or $id == null)
		{
			Session::set_flash('error', 'Invalid path ID');
			Response::redirect('admin');
		}

		try
		{
			$scanner = new Scanner_Movie($path);
			$scanner->scan();

			$inserts = $scanner->get_and_reset_inserts();

			$new = isset($inserts['new']) ? count($inserts['new']) : 0;
			$updated = isset($inserts['updated']) ? count($inserts['updated']) : 0;
			Session::set_flash('success', 'Scanned ' . ($new + $updated) . ' movies; ' . $new . ' was added and ' . $updated . ' was updated.');
		}
		catch (MissingScraperGroupException $e)
		{
			Session::set_flash('error', $e->getMessage());
		}

		Response::redirect('admin/tools/import');
	}

}