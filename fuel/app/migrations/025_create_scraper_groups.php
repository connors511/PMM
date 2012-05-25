<?php

namespace Fuel\Migrations;

class Create_scraper_groups
{
	public function up()
	{
		\DBUtil::create_table('scraper_groups', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'scraper_type_id' => array('constraint' => 11, 'type' => 'int'),
			'comment' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
		\DBUtil::drop_table('scrapergroup_movies');
	}

	public function down()
	{
		\DBUtil::drop_table('scraper_groups');
		\DBUtil::create_table('scrapergroup_movies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'title' => array('constraint' => 11, 'type' => 'int'),
			'plot' => array('constraint' => 11, 'type' => 'int'),
			'plotsummary' => array('constraint' => 11, 'type' => 'int'),
			'tagline' => array('constraint' => 11, 'type' => 'int'),
			'rating' => array('constraint' => 11, 'type' => 'int'),
			'votes' => array('constraint' => 11, 'type' => 'int'),
			'released' => array('constraint' => 11, 'type' => 'int'),
			'runtime' => array('constraint' => 11, 'type' => 'int'),
			'contentrating' => array('constraint' => 11, 'type' => 'int'),
			'originaltitle' => array('constraint' => 11, 'type' => 'int'),
			'trailer_url' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}
}