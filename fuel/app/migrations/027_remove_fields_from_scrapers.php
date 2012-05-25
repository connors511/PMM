<?php

namespace Fuel\Migrations;

class Remove_fields_from_scrapers
{
	public function up()
	{
		\DBUtil::drop_fields('scrapers', array(
			'fields'
    
		));
	}

	public function down()
	{
		\DBUtil::add_fields('scrapers', array(
			'fields' => array('type' => 'text'),

		));	
	}
}