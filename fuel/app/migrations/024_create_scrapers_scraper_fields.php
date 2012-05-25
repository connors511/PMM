<?php

namespace Fuel\Migrations;

class Create_scrapers_scraper_fields
{
	public function up()
	{
		\DBUtil::create_table('scrapers_scraper_fields', array(
			'scraper_id' => array('constraint' => 11, 'type' => 'int'),
			'scraper_field_id' => array('constraint' => 11, 'type' => 'int'),

		), array('scraper_id','scraper_field_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('scrapers_scraper_fields');
	}
}