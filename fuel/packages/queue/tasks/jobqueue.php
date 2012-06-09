<?php
/**
 * Fuel-queue a simple queue module for FuelPHP
 *
 * @package    Queue
 * @author     Kavinsky
 * @license    MIT License
 * @copyright  2010 - 2011 Ignacio "Kavinsky" Muñoz
 * @link       http://github.com/kavinsky/fuel-queue
 */
namespace Fuel\Tasks;


class Jobqueue
{
	public static function run($queue = null, $runs = 25)
	{
		if ($queue === null)
		{
			$queue = 'default';
		}
				
		\Cli::write('[INFO] Processing queue: '.$queue);		
		
		try {
			
			$run_number = 0;
			while(true)
			{
				sleep(5);
				\Cli::write('[INFO] Starting run');
				
				$queue_size = \Queue::size($queue);
				
				if($queue_size == 0)
				{
					continue;
				}
				
				if ($queue_size < 25)
				{
					$runs = $queue_size;
				}
				
				\Cli::write('[INFO] Queue size: '.$queue_size);
				$total_usage = 0;		
				for($i = 0; $i < $runs; ++$i)
				{				
					// execution environment
					$job = \Queue::pop($queue);
					\Cli::write('[INFO] -------------- RUNNING JOB: '.$job['task'].' args:'.@implode(',',$job['args']));
					\Oil\Refine::run($job['task'], $job['args']);
					$total_usage += memory_get_usage();
					\Cli::write('[INFO] -------------- END JOB: memory usage: '.\Num::format_bytes(memory_get_usage(), 2).' elapsed time:');
				}
				
				\Cli::write("[INFO] Performed $i jobs");	
				if($i > 0)
				{
					\Cli::write("[INFO] Total memory usage in this batch: ".\Num::format_bytes($total_usage, 2));
					\Cli::write("[INFO] ".\Queue::size($queue)." jobs lefts on the queue $queue");
				}
							
				
				$run_number++;
			}
			
		}
		catch(Exception $e)
		{
			\Cli::color("[ERROR] Error: ". $e->getMessage(), 'red');
		}
		
		
		\Cli::write('Total executions: '.$i);
		\Cli::write('Execution completed!');
	}
	
	public static function help()
	{
		\Cli::write('Usage: php oil r|refine [<queue_name>]');
		\Cli::write('If you dont specify the queue_name then will use "default" queue');
	}
}