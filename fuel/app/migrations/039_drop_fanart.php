<?php

namespace Fuel\Migrations;

class Drop_fanart
{
	public function up()
	{
		\DBUtil::drop_table('fanart');
	}

	public function down()
	{
		\DBUtil::create_table('fanart', array(
			'id' => array('type' => 'int', 'null' => true, 'constraint' => 11, 'auto_increment' => true),
			'movie_id' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'image_id' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}