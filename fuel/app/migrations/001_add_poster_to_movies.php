<?php

namespace Fuel\Migrations;

class Add_poster_to_movies
{
	public function up()
	{
		\DBUtil::add_fields('movies', array(
			'poster' => array('type' => 'text'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('movies', array(
			'poster'
    
		));
	}
}