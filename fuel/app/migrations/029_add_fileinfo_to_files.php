<?php

namespace Fuel\Migrations;

class Add_fileinfo_to_files
{

	public function up()
	{
		\DBUtil::add_fields('files', array(
		    'size' => array('constraint' => 11, 'type' => 'bigint'),
		    'realpath' => array('type' => 'text'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('files', array(
		    'size',
		    'realpath'
		));
	}

}