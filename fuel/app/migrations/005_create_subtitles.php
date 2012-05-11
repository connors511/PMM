<?php

namespace Fuel\Migrations;

class Create_subtitles
{
	public function up()
	{
		\DBUtil::create_table('subtitles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'file_id' => array('constraint' => 11, 'type' => 'int'),
			'language' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
			'file_id' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('subtitles');
	}
}