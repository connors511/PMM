<?php

namespace Fuel\Migrations;

class Create_actors
{
	public function up()
	{
		\DBUtil::create_table('actors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'person_id' => array('constraint' => 11, 'type' => 'int'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'role' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('actors');
	}
}