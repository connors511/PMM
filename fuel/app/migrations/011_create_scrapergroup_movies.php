<?php

namespace Fuel\Migrations;

class Create_scrapergroup_movies
{
	public function up()
	{
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

	public function down()
	{
		\DBUtil::drop_table('scrapergroup_movies');
	}
}