<?php

namespace Fuel\Migrations;

class Rename_poster_to_poster_id_in_movies
{
	public function up()
	{

		\DBUtil::drop_fields('movies', array(
			'poster'
    
		));
		\DBUtil::add_fields('movies', array(
			'poster_id' => array('type' => 'int', 'null'=>true),

		));	
	}

	public function down()
	{

		\DBUtil::drop_fields('movies', array(
			'poster_id'
    
		));
		\DBUtil::add_fields('movies', array(
			'poster' => array('type' => 'text', 'null'=>true),

		));	
	}
}