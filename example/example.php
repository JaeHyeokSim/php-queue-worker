<?php

require_once "../src/Queue.php";
require_once "../src/Worker.php";

$queue = new Queue(__DIR__ . "/queue.json");

$queue->push([
	"id" => uniqid(),
	"type" => "email",
	"user" => 1,
	"attempts" => 0
]);

$queue->push([
	"id" => uniqid(),
	"type" => "email",
	"user" => 2,
	"attempts" => 0
]);

$worker = new Worker($queue);

$worker->run(function($job){

	echo "Processing job: " . json_encode($job) . "\n";

});