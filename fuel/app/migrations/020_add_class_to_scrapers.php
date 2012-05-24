<?php

namespace Fuel\Migrations;

class Add_class_to_scrapers
{
	public function up()
	{
		\DBUtil::add_fields('scrapers', array(
			'class' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('scrapers', array(
			'class'
    
		));
	}
}