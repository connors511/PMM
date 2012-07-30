<?php

namespace Fuel\Migrations;

class Create_stream_audios
{
	public function up()
	{
		\DBUtil::create_table('stream_audios', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'bitrate' => array('constraint' => 11, 'type' => 'int'),
			'samplerate' => array('constraint' => 11, 'type' => 'int'),
			'codec' => array('constraint' => 255, 'type' => 'varchar'),
			'channels' => array('constraint' => 11, 'type' => 'int'),
			'language' => array('constraint' => 255, 'type' => 'varchar'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('stream_audios');
	}
}