<?php

namespace Fuel\Migrations;

class Create_images
{
	public function up()
	{
		\DBUtil::create_table('images', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'file_id' => array('constraint' => 11, 'type' => 'int'),
			'height' => array('constraint' => 11, 'type' => 'int'),
			'width' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('images');
	}
}