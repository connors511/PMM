<?php

namespace Fuel\Migrations;

class Create_movies
{
	public function up()
	{
		\DBUtil::create_table('movies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'plot' => array('type' => 'text'),
			'plotsummary' => array('constraint' => 255, 'type' => 'varchar'),
			'tagline' => array('constraint' => 255, 'type' => 'varchar'),
			'rating' => array('type' => 'double'),
			'votes' => array('constraint' => 11, 'type' => 'int'),
			'released' => array('constraint' => 11, 'type' => 'int'),
			'runtime' => array('constraint' => 11, 'type' => 'int'),
			'runtime_file' => array('constraint' => 11, 'type' => 'int'),
			'contentrating' => array('constraint' => 255, 'type' => 'varchar'),
			'originaltitle' => array('constraint' => 255, 'type' => 'varchar'),
			'thumb' => array('constraint' => 11, 'type' => 'int'),
			'fanart' => array('constraint' => 11, 'type' => 'int'),
			'trailer_url' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('movies');
	}
}
