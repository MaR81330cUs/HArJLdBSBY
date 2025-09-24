<?php
// 代码生成时间: 2025-09-24 10:19:07
// Ensure error reporting is on for development
error_reporting(E_ALL);

// Autoload Zend components
require 'vendor/autoload.php';

use Zend\Cron\CronExpression;
use Zend\Cron\Job;
use Zend\Cron\Runner;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;
use DateTime;
use DateTimeZone;

class MyCronJob implements Job
{
    public function run()
    {
        // Your job logic goes here
        echo "Cron job executed at: " . date("Y-m-d H:i:s") . "\
";
        return true;
    }
}

// Configuration for the cron runner
$config = [
    'jobs' => [
        // Define your jobs here
        [
            'name' => 'My Cron Job',
            'job' => new MyCronJob(),
            'rule' => '* * * * *', // This means the job runs every minute
        ],
    ],
];

// Create a logger
$logger = new Logger();
$logger->addWriter(new StreamWriter('cron_log.txt'));

// Create a runner with the logger
$runner = new Runner($config, $logger);

// Run the runner
try {
    $runner->run();
} catch (Exception $e) {
    // Handle exceptions
    $logger->err($e->getMessage());
    exit(1);
}
