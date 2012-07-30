<?php

namespace Fuel\Migrations;

class Create_stream_videos
{
	public function up()
	{
		\DBUtil::create_table('stream_videos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'duration' => array('type' => 'float'),
			'frames' => array('constraint' => 11, 'type' => 'int'),
			'fps' => array('type' => 'float'),
			'height' => array('constraint' => 11, 'type' => 'int'),
			'width' => array('constraint' => 11, 'type' => 'int'),
			'pixelformat' => array('constraint' => 255, 'type' => 'varchar'),
			'bitrate' => array('constraint' => 11, 'type' => 'int'),
			'codec' => array('constraint' => 255, 'type' => 'varchar'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('stream_videos');
	}
}