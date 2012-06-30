<?php

namespace Fuel\Migrations;

class Drop_thumb_and_fanart_from_movies
{
	public function up()
	{
		\DBUtil::drop_fields('movies', array(
			'thumb',
			'fanart'
		));	
	}

	public function down()
	{
		\DBUtil::add_fields('movies', array(
			'thumb' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
			'fanart' => array('constraint' => 11, 'type' => 'int', 'null'=>true),
		));
	}
}