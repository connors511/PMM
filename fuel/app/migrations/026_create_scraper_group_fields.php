<?php

namespace Fuel\Migrations;

class Create_scraper_group_fields
{
	public function up()
	{
		\DBUtil::create_table('scraper_group_fields', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'scraper_group_id' => array('constraint' => 11, 'type' => 'int'),
			'scraper_field_id' => array('constraint' => 11, 'type' => 'int'),
			'scraper_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('scraper_group_fields');
	}
}
