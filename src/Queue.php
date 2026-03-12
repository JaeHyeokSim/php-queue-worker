<?php

class Queue {

	private $file;

	public function __construct($file) {
		$this->file = $file;

		if (!file_exists($file)) {
			file_put_contents($file, json_encode([]));
		}
	}

	public function push($job) {

		$queue = json_decode(file_get_contents($this->file), true);

		$queue[] = $job;

		file_put_contents($this->file, json_encode($queue));
	}

	public function pop() {

		$queue = json_decode(file_get_contents($this->file), true);

		if (empty($queue)) {
			return null;
		}

		$job = array_shift($queue);

		file_put_contents($this->file, json_encode($queue));

		return $job;
	}
}