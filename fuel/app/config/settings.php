<?php

return array(
    'jobs' => array(
	'use' => true,
    ),
    'scanner' => array(
	'exists' => array(
	    ''
	)
    ),
    'export' => array(
	'save_locations' => array(
	    'subtitles' => '$movie->file->folder()'.DS.'$movie->file->name(false).srt',
	    'fanart' => '$movie->file->folder()'.DS.'fanart'.DS.'$file->name()',
	    'poster' => array(
		'$movie->file->folder()'.DS.'poster.$file->ext()',
		'$movie->file->folder()'.DS.'$movie->file->name(false).$file->ext()'
	    ),
	    'folder' => '$movie->file->folder()'.DS.'folder.$file->ext()',
	    'nfo' => '$movie->file->folder()'.DS.'movie.nfo',
	)
    ),
    'binaries' => array(
	'ffmpeg' => 'ffmpeg'
    )
);