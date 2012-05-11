<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of time
 *
 * @author Matthias
 */
class Time
{

	static function time_elapsed_sec($secs)
	{
		$bit = array(
		    'y' => $secs / 31556926 % 12,
		    'w' => $secs / 604800 % 52,
		    'd' => $secs / 86400 % 7,
		    'h' => $secs / 3600 % 24,
		    'm' => $secs / 60 % 60,
		    's' => $secs % 60
		);

		foreach ($bit as $k => $v)
			if ($v > 0)
				$ret[] = $v . $k;

		return join(' ', $ret);
	}

	static function time_elapsed_min($min)
	{
		return Time::time_elapsed_sec($min * 60);
	}

}

?>
