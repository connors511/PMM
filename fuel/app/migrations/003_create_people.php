<?php

namespace Fuel\Migrations;

class Create_people
{
	public function up()
	{
		\DBUtil::create_table('people', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'biography' => array('type' => 'text'),
			'birthname' => array('constraint' => 255, 'type' => 'varchar'),
			'birthday' => array('constraint' => 11, 'type' => 'int'),
			'birthlocation' => array('constraint' => 255, 'type' => 'varchar'),
			'height' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('people');
	}
}
