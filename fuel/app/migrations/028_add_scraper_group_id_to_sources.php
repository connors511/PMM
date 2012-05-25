<?php

namespace Fuel\Migrations;

class Add_scraper_group_id_to_sources
{
	public function up()
	{
		\DBUtil::add_fields('sources', array(
			'scraper_group_id' => array('constraint' => 11, 'type' => 'int'),

		));	
		\DBUtil::drop_fields('sources', array(
			'scrapergroup'
    
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('sources', array(
			'scraper_group_id'
    
		));
		\DBUtil::add_fields('sources', array(
			'scrapergroup' => array('constraint' => 11, 'type' => 'int'),

		));
	}
}