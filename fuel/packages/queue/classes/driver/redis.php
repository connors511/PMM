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

class Driver_Redis
{

	private $_redis = null;

	public function __construct()
	{
		$this->_redis = \Redis::instance(\Config::get('drivers.redis.store', 'default'));
	}

	public function push($queue, $item)
	{
		$this->_redis->sadd('queues', $queue);
		$this->_redis->rpush('queue:' . $queue, json_encode($item));
	}

	public function pop($queue)
	{
		$item = $this->_redis->lpop('queue:' . $queue);
		if (!$item)
		{
			return;
		}

		return json_decode($item, true);
	}

	public function size($queue)
	{
		return $this->_redis->llen('queue:' . $queue);
	}

	public function enqueue($task, $queue, $args, $prio)
	{

		$result = Job::create($task, $queue, $args, $prio);
		if ($result)
		{
			\Event::trigger('queue.after_enqueue', array(
			    'task' => $task,
			    'args' => $args,
			    'prio' => $prio
			));
		}

		return $result;
	}

	public function reserve($queue)
	{
		return Job::reserve($queue);
	}

	public function queues()
	{
		$queues = $this->_redis->smembers('queues');
		if (!is_array($queues))
		{
			$queues = array();
		}
		return $queues;
	}

}