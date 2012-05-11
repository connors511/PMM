<?php

namespace Fuel\Migrations;

class Create_directors
{
	public function up()
	{
		\DBUtil::create_table('directors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'person_id' => array('constraint' => 11, 'type' => 'int'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('directors');
	}
}