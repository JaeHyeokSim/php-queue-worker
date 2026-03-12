<?php

class Queue
{

	private $file;

	public function __construct($file)
	{
		$this->file = $file;

		if (!file_exists($file)) {
			file_put_contents($file, json_encode([]));
		}
	}

	public function push($job)
	{

		$fp = fopen($this->file, "c+");

		flock($fp, LOCK_EX);

		$queue = json_decode(stream_get_contents($fp), true);

		if (!$queue) {
			$queue = [];
		}

		$queue[] = $job;

		ftruncate($fp, 0);
		rewind($fp);

		fwrite($fp, json_encode($queue));

		flock($fp, LOCK_UN);

		fclose($fp);
	}

	public function pop()
	{

		$fp = fopen($this->file, "c+");

		flock($fp, LOCK_EX);

		$queue = json_decode(stream_get_contents($fp), true);

		if (!$queue || empty($queue)) {

			flock($fp, LOCK_UN);
			fclose($fp);

			return null;
		}

		$job = array_shift($queue);

		ftruncate($fp, 0);
		rewind($fp);

		fwrite($fp, json_encode($queue));

		flock($fp, LOCK_UN);

		fclose($fp);

		return $job;
	}
}
