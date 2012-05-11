<?php

namespace Fuel\Migrations;

class Add_file_id_to_movies
{
	public function up()
	{
    \DBUtil::add_fields('movies', array(
						'file_id' => array('constraint' => 11, 'type' => 'int'),

    ));	
	}

	public function down()
	{
    \DBUtil::drop_fields('movies', array(
			'file_id'    
    ));
	}
}