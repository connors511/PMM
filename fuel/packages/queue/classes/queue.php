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
namespace Queue;

/**
 * Base Queue Class.
 */
class Queue
{
	/**
	 * @var Driver instance
	 */
	public static $instance = null;
	
	public static function _init()
	{
		\Config::load(include __DIR__.'/../config/queue.php', 'queue');		
		$driver_active = \Config::get('queue.activedriver');		
		$driver_class  = \Config::get('queue.drivers.'.$driver_active.'.drivername');		

		static::$instance = new $driver_class;
	}
	
	/**
	 * Push a job to the end of a specific queue. If the queue does not
	 * exist, then create it as well.
	 * 
	 * @param string $queue The name of the queue to add the job to.
	 * @param object $item Job description as an object to be JSON encoded.
	 * @return void
	 */
	public static function push($queue, $item)
	{
		return static::$instance->push($queue, $item);
	}
	
	/**
	 * Pop an item off the end of the specified queue, decode it and
	 * return it.
	 *
	 * @param string $queue The name of the queue to fetch an item from.
	 * @return object Decoded item from the queue.
	 */
	public static function pop($queue)
	{
		return static::$instance->pop($queue);
	}
	
	/**
	 * Return the size (number of pending jobs) of the specified queue.
	 * 
	 * @param int $queue The size of the queue.
	 */
	public static function size($queue)
	{
		return static::$instance->size($queue);
	}
	
	/**
	 * Create a new job and save it to the specified queue.
	 * 
	 * @param string $queue The name of the queue to place the job in.
	 * @param string $class The name of the class that contains the code to execute the job.
	 * @param array $args Any optional arguments that should be passed when the job is executed.
	 */
	public static function enqueue($task, $queue = 'default', $args = array(), $prio = 1)
	{
		return static::$instance->enqueue($task, $queue, $args, $prio);
	}
	
	/**
	 * Reserve and return the next available job in the specified queue.
	 * 
	 * @param string $queue Queue to fetch next available job from.
	 */
	public static function reserve($queue)
	{
		return static::$instance->reserve($queue);
	}
	
	/**
	 * Get an array with all know queues.
	 * 
	 * @return array Array of queues.
	 */
	public static function queues()
	{
		return static::$instance->queues();
	}
}