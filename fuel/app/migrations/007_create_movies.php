<?php

namespace Fuel\Migrations;

class Create_movies
{
	public function up()
	{
		\DBUtil::create_table('movies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar', 'null'=>true),
			'plot' => array('type' => 'text', 'null'=>true),
			'plotsummary' => array('constraint' => 255, 'type' => 'varchar', 'null'=>true),
			'tagline' => array('constraint' => 255, 'type' => 'varchar', 'null'=>true),
			'rating' => array('type' => 'double', 'null'=>true),
			'votes' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'released' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'runtime' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'runtime_file' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'contentrating' => array('constraint' => 255, 'type' => 'varchar', 'null'=>true),
			'originaltitle' => array('constraint' => 255, 'type' => 'varchar', 'null'=>true),
			'thumb' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'fanart' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'trailer_url' => array('type' => 'text', 'null'=>true),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('movies');
	}
}
