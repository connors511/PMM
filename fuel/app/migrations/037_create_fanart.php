<?php

namespace Fuel\Migrations;

class Create_fanart
{
	public function up()
	{
		\DBUtil::create_table('fanart', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'image_id' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('fanart');
	}
}