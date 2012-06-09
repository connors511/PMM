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


return array(

	
	/*
	 * Current active driver (i.e: db = Driver_DB)
	 */
	'activedriver' => 'db',
	
	/*
	 * list of drivers and their configurations
	 */
	'drivers' => array(
		//
		// DB Driver
		/* Database table for DB Driver
		 * ===================================================================================
		  CREATE TABLE `queue` (
			  `id` bigint(22) NOT NULL AUTO_INCREMENT,
			  `queue` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `priority` int(1) NOT NULL DEFAULT '5',
			  `payload` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		  =================================================================================== 
		*/
		'db' => array(
			'drivername' 	=> 'Driver_DB',
			'tablename'		=> 'queue',
			'connection'	=> false,
		),
		
		//
		// Redis Driver
		'redis' => array(
			'drivername' 	=> 'Driver_Redis',
			'store'			=> 'queue',
		),
		
		// not working
		'beanstalkd' => array(
			'drivername'	=> 'Driver_Beanstalkd',
			
		),
		
		//not working
		'mongodb'	=> array(
			'drivername'	=> 'Driver_MongoDB',
			
		),
	),
);