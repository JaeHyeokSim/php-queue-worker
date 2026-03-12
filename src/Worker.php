<?php

class Worker
{

    private $queue;

    public function __construct($queue)
    {
        $this->queue = $queue;
    }

    public function run(callable $handler)
    {

        while (true) {

            $job = $this->queue->pop();

            if (!$job) {
                sleep(1);
                continue;
            }

            try {

                $handler($job);
            } catch (Exception $e) {

                $job["attempts"]++;

                if ($job["attempts"] < 3) {

                    $this->queue->push($job);
                } else {

                    echo "Job failed permanently: " . $job["id"] . "\n";
                }
            }
        }
    }
}
