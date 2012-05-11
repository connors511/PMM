<?php

namespace Fuel\Migrations;

class Create_scrapers
{
	public function up()
	{
		\DBUtil::create_table('scrapers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'author' => array('constraint' => 255, 'type' => 'varchar'),
			'type' => array('constraint' => 255, 'type' => 'varchar'),
			'version' => array('constraint' => 255, 'type' => 'varchar'),
			'fields' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('scrapers');
	}
}