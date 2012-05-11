<?php

namespace Fuel\Migrations;

class Create_sources
{
	public function up()
	{
		\DBUtil::create_table('sources', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'path' => array('type' => 'text'),
			'scrapergroup' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sources');
	}
}