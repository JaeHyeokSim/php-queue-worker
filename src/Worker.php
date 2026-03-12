<?php

class Worker {

	private $queue;

	public function __construct($queue) {
		$this->queue = $queue;
	}

	public function run(callable $handler) {

		while (true) {

			$job = $this->queue->pop();

			if (!$job) {
				sleep(1);
				continue;
			}

			$handler($job);
		}
	}
}