<?php

namespace Fuel\Migrations;

class Add_image_id_to_web_images
{
	public function up()
	{
		\DBUtil::add_fields('web_images', array(
			'image_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('web_images', array(
			'image_id'
    
		));
	}
}