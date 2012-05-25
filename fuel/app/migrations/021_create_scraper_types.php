<?php

namespace Fuel\Migrations;

class Create_scraper_types
{
	public function up()
	{
		\DBUtil::create_table('scraper_types', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'type' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
		\DBUtil::create_index('scraper_types','type','unique_type','unique');
	}

	public function down()
	{
		\DBUtil::drop_table('scraper_types');
	}
}