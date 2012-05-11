<?php

namespace Fuel\Migrations;

class Add_movie_id_to_images
{
	public function up()
	{
    \DBUtil::add_fields('images', array(
						'movie_id' => array('constraint' => 11, 'type' => 'int'),

    ));	
	}

	public function down()
	{
    \DBUtil::drop_fields('images', array(
			'movie_id'    
    ));
	}
}