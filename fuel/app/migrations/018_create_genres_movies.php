<?php

namespace Fuel\Migrations;

class Create_genres_movies
{
	public function up()
	{
		\DBUtil::create_table('genres_movies', array(
			'genre_id' => array('constraint' => 11, 'type' => 'int'),
			'movie_id' => array('constraint' => 11, 'type' => 'int'),

		), array('genre_id','movie_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('genres_movies');
	}
}
