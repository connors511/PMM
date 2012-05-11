<?php

namespace Fuel\Migrations;

class Add_source_id_to_files
{
	public function up()
	{
    \DBUtil::add_fields('files', array(
						'source_id' => array('constraint' => 11, 'type' => 'int'),

    ));	
	}

	public function down()
	{
    \DBUtil::drop_fields('files', array(
			'source_id'    
    ));
	}
}