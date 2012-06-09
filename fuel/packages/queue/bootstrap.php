<?php
/**
 * Fuel-queue a simple queue module for FuelPHP
 *
 * @package    Queue
 * @author     Kavinsky
 * @license    MIT License
 * @copyright  2011 Ignacio "Kavinsky" Muñoz
 * @link       http://github.com/kavinsky/fuel-queue
 */

Autoloader::add_core_namespace('Queue');

Autoloader::add_classes(array(
	'Queue\\Queue'             			=> __DIR__.'/classes/queue.php',
	'Queue\\Job'						=> __DIR__.'/classes/job.php',
	'Queue\\Queue_Exception'   			=> __DIR__.'/classes/exception.php',
	'Queue\\Queue_Job_DontPerform' 		=> __DIR__.'/classes/exception.php',
	
	// Driver
	'Queue\\Driver_Redis'				=> __DIR__.'/classes/driver/redis.php',
	'Queue\\Driver_DB'				=> __DIR__.'/classes/driver/db.php',
	
	
	// Tasks
	'Fuel\\Tasks\\Queue'				=> __DIR__.'/classes/tasks/queue.php',
));