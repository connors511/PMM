<?php

namespace Fuel\Migrations;

class Create_scraper_fields
{
	public function up()
	{
		\DBUtil::create_table('scraper_fields', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'field' => array('constraint' => 255, 'type' => 'varchar'),
			'scraper_type_id' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
		\DBUtil::create_index('scraper_fields',array('field','scraper_type_id'),'unique_type','unique');
	}

	public function down()
	{
		\DBUtil::drop_table('scraper_fields');
	}
}