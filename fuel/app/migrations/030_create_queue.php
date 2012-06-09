<?php

namespace Fuel\Migrations;

class Create_queue
{
	public function up()
	{
		\DBUtil::create_table('queue', array(
			'id' => array('constraint' => 22, 'type' => 'bigint', 'auto_increment' => true),
			'queue' => array('constraint' => 255, 'type' => 'varchar'),
			'priority' => array('constraint' => 11, 'type' => 'int'),
			'payload' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('queue');
	}
}