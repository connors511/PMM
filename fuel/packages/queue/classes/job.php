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

class Job
{

	public $queue;
	public $payload;

	public function __construct($queue, $payload)
	{
		$this->queue = $queue;
		$this->payload = $payload;
	}

	public static function create($task, $queue = 'default', $args = array(), $prio = 1)
	{
		if ($args !== null and !is_array($args))
		{
			throw new \Fuel_Exception('Invalid agruments: Supplied $args must be an array.');
		}

		Queue::push($queue, array(
		    'task' => $task,
		    'args' => $args,
		    'prio' => $prio
		));
	}

	public static function reserve($queue)
	{
		$payload = Queue::pop($queue);
		if (!$payload)
		{
			return false;
		}

		return new Job($queue, $payload);
	}

	public function run()
	{
		$class = '\\Fuel\\Task\\' . $this->payload['task'];
		try
		{
			\Event::trigger('queue.before_run', $this);

			if (method_exists($class, 'up'))
			{
				\Oil\Refine::run($this->payload['task'] . ':up', $this->payload['args']);
			}
			\Oil\Refine::run($this->payload['task'], $this->payload['args']);

			if (method_exists($class, 'down'))
			{
				\Oil\Refine::run($this->payload['task'] . ':down', $this->payload['args']);
			}

			\Event::trigger('queue.after_run', $this);
		}
		catch (Queue_Job_DontPerform $e)
		{
			return false;
		}

		return true;
	}

	public function __toString()
	{
		$name = array(
		    'Queue_Job{' . $this->queue . '}'
		);

		if (!empty($this->payload['id']))
		{
			$name[] = 'ID: ' . $this->payload['id'];
		}
		$name[] = $this->payload['task'];
		if (!empty($this->payload['args']))
		{
			$name[] = json_encode($this->payload['args']);
		}
		return '(' . implode(' | ', $name) . ')';
	}

}