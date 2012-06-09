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

class Queue_Exception extends Fuel_Exception {}
class Queue_Job_DontPerform extends Queue_Exception {}