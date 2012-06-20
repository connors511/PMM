<?php

class Pagination extends \Fuel\Core\Pagination
{
	public static function total_items()
	{
		return self::$total_items;
	}
}