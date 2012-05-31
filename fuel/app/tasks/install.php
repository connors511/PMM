<?php

namespace Fuel\Tasks;

class Install
{
	public static function output($var,$k = "")
	{
		if (is_array($var))
		{
			foreach($var as $k=>$v)
			{
				Install::output($v,$k);
			}
		}
		else
		{
			\Cli::write($k." = ".$var);
		}
	}
	public static function run()
	{
		$pmm = \Cli::color('P','red') . \Cli::color('M','blue') . \Cli::color('M','green');
		\Config::load('development/db','db');
		\Config::load('config','base');
		
		\Cli::write("
			*************************************************
			*     {$pmm} Media Manager Installation Wizard     *
			*************************************************");
		\Cli::write("This wizard will take you through the installation of the PHP Media Manager.");
		\Cli::write("
			*************************************************
			*		Database installation		*
			*************************************************");
		\Cli::write("NOTE: The installer currently only supports MySQL.", 'red');
		do {
			$host = \Cli::prompt('What is your database host?');
			$user = \Cli::prompt('What is your database user?');
			$pass = \Cli::prompt('What is your database password?');
			$db_name = \Cli::prompt('What is the name of the database?');
			$mysqli = \Cli::prompt('Is MySQLi installed?', array('y','n'));
			\Cli::write('Please confirm that the following information is correct:','yellow');
			\Cli::write("Database host: {$host}
Username: {$user}
Password: {$pass}
Datbase name: {$db_name}
MySQLi: {$mysqli}");
			$confirm = \Cli::prompt('Is the information correct?', array('y','n'));
		} while($confirm != 'y');
		// Save DB info
		\Config::set('db.profiling','false');
		\Config::set('db.type',$mysqli == 'y' ? 'mysqli' : 'mysql');
		\Config::set('db.default.connection.hostname',$host);
		\Config::set('db.default.connection.username',$user);
		\Config::set('db.default.connection.password',$pass);
		\Config::set('db.default.connection.database',$db_name);
				
		\Cli::write("
			*************************************************
			*		{$pmm} installation		*
			*************************************************");
		do {
			$pretty_url = \Cli::prompt("Do you want pretty urls? NOTE: This requires mod_rewrite module!", array('y','n'));
			$scan_scrapers = \Cli::prompt("Would you like to scan for scrapers after install?", array('y','n'));
			$default_scraper_groups = \Cli::prompt("Would you like to have default scraper groups installed?", array('y','n'));
			
			\Cli::write('Please confirm that the following information is correct:','yellow');
			\Cli::write("Pretty url: {$pretty_url}");
			
			$confirm = \Cli::prompt('Is the information correct?', array('y','n'));
		} while($confirm != 'y');
		// Save config
		\Config::set('index_file', $pretty_url == 'y' ? false : 'index.php');
		\Config::set('profiling',false);
		
		
		
		\Cli::write('Starting installation...','green');
		
		\Config::save('config','base');
		\Config::save('development/db','db');
		\Cli::write("Saved config files",'green');
		
		// Create db
		\Cli::write("Using database '{$db_name}'",'green');
		
		// Migrate
		\Cli::write("Installing database",'green');
		\Package::load('oil');
		\Oil\Refine::run('migrate',array());
		\Cli::write('Installed database','green');

		// Scan for scrapers
		if ($scan_scrapers == 'y')
		{
			\Cli::write('Scanning scrapers','yellow');
			
			$stats = array('new' => 0, 'updated' => 0, 'existing' => 0);
			$files = \File::read_dir(APPPATH . 'classes/scraper');
			foreach ($files as $file)
			{
				$info = \File::file_info(APPPATH . 'classes/scraper/' . $file);
				$class = 'Scraper_' . ucfirst($info['filename']);
				$scraper = new $class();
				$tmp = \Model_Scraper::find('first', array(
					'where' => array(
						array('name', '=', $scraper->get_name())
					)
					));
				if ($tmp == null)
				{
					$tmp = new \Model_Scraper();
					$tmp->name = $scraper->get_name();
					$tmp->author = $scraper->get_author();
					$tmp->scraper_type = $scraper->get_type();
					$tmp->version = $scraper->get_version();
					$tmp->scraper_fields = $scraper->get_supported_fields();
					$tmp->class = $class;
					$stats['new']++;
					
					\Cli::write("Found {$tmp->scraper_type->type} scraper: {$tmp->name} (v{$tmp->version}) by {$tmp->author}.",'blue');
				}
				else
				{
					if ($tmp->version < $scraper->get_version())
					{
						// Update version
						// Author and fields could've changed
						$tmp->author = $scraper->get_author();
						$tmp->scraper_type = $scraper->get_type();
						$tmp->version = $scraper->get_version();
						$tmp->scraper_fields = $scraper->get_supported_fields();
						$tmp->class = $class;
						$stats['updated']++;
						\Cli::write("Updated {$tmp->scraper_type->type} scraper: {$tmp->name} (v{$tmp->version}) by {$tmp->author}.",'blue');
				
					}
					else
					{
						$stats['existing']++;
						\Cli::write("Skipped {$tmp->scraper_type->type} scraper: {$tmp->name} (v{$tmp->version}) by {$tmp->author} vs installed v{$tmp->version}.",'blue');
				
					}
				}
				$tmp->save();
			}

			\Cli::write('Added ' . $stats['new'] . ', updated ' . $stats['updated'] . ' and skipped ' . $stats['existing'] . ' scrapers.','green');
		}
		if ($default_scraper_groups == 'y')
		{
			// Install default scrapers
			$scrapers = \Model_Scraper::find('all');
			foreach($scrapers as $scraper)
			{
				$group = new \Model_Scraper_Group();
				$group->name = $scraper->name;
				$group->scraper_type = $scraper->scraper_type;
				$group->comment = 'Auto generated';
				$fields = $scraper->scraper_fields;
				foreach ($fields as $k => $field)
				{
					$sgf = new \Model_Scraper_Group_Field();
					$sgf->scraper = $scraper;
					$sgf->scraper_field = $field;
					$sgf->scraper_group = $group;
					$sgf->save();
				}
				$group->save();
				\Cli::write("Added scraper group for scraper {$scraper->name}", 'green');
			}
		}
		
		$create_acc = \Cli::prompt('Would you like to create admin account(s)? (recommended)', array('y','n'));
		if ($create_acc == 'y')
		{
			while(true)
			{
				$username = \Cli::prompt("Which username would you like for the administrator account?");
				$password = \Cli::prompt("Choose a password for the administrator account");
				$mail = \Cli::prompt("What is the email for the administrator account");
				try 
				{
					\Auth::create_user($username,$password,$mail,100);
					\Cli::write("Created admin account '{$username}'",'green');
					$other_account = \Cli::prompt('Would you like to create another admin account?',array('y','n'));
					if ($other_account == 'n')
					{
						break 1;
					}
				}
				catch(\SimpleUserUpdateException $e)
				{
					\Cli::write($e->getMessage(), 'red');
				}
			}
		}
		\Cli::write('Installation complete.','green');
		
	}
}