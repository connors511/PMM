<?php

namespace Fuel\Migrations;

class Create_web_images
{
	public function up()
	{
		\DBUtil::create_table('web_images', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'url' => array('type' => 'text'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'type' => array('constraint' => 11, 'type' => 'int'),
			'height' => array('constraint' => 11, 'type' => 'int'),
			'width' => array('constraint' => 11, 'type' => 'int'),
			'source' => array('constraint' => 11, 'type' => 'int'),
			'data' => array('type' => 'mediumtext'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('web_images');
	}
}