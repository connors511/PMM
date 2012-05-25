<?php

namespace Fuel\Migrations;

class Add_role_to_producers
{
	public function up()
	{
		\DBUtil::add_fields('producers', array(
			'role' => array('constraint' => 255, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('producers', array(
			'role'
    
		));
	}
}