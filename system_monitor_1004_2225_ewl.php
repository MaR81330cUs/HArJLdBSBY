<?php
// 代码生成时间: 2025-10-04 22:25:51
// Autoload files using Composer's autoload
require_once 'vendor/autoload.php';

use Zend\Mvc\Application;
use Zend\Mvc\ApplicationInterface;
use Zend\ServiceManager\ServiceManager;

// Define the entry point of the application
define('APPLICATION_ENTRY_POINT', __DIR__);

// Define the root directory of the application
define('ROOT_DIR', realpath(APPLICATION_ENTRY_POINT . '/../'));

try {
    // Retrieve the application
    $app = require 'config/application.config.php';

    // Run the application
    $app->run();
} catch (Exception $e) {
    // Handle exceptions
    echo 'An error occurred: ',  $e->getMessage(), "\
";
}

// Define a class to handle system resource monitoring
class SystemMonitor {
    /**
     * Get system load averages
     *
     * @return array
     */
    public function getSystemLoadAverages() {
        if (!function_exists('sys_getloadavg')) {
            throw new Exception('sys_getloadavg function is not available on this system.');
        }

        return sys_getloadavg();
    }

    /**
     * Get memory usage
     *
     * @return array
     */
    public function getMemoryUsage() {
        return [
            'memory_usage' => memory_get_usage(),
            'memory_peak_usage' => memory_get_peak_usage(),
        ];
    }

    /**
     * Get disk usage
     *
     * @return array
     */
    public function getDiskUsage() {
        $diskUsage = [];
        $mounts = explode("\
", shell_exec('df -h'));
        foreach ($mounts as $mount) {
            $parts = explode(" ", $mount);
            $diskUsage[$parts[0]] = [
                'total' => $parts[1],
                'used' => $parts[2],
                'free' => $parts[3],
                'percent' => $parts[4],
            ];
        }

        return $diskUsage;
    }

    /**
     * Get CPU information
     *
     * @return array
     */
    public function getCpuInfo() {
        $cpuInfo = [];
        $cpuData = file_get_contents('/proc/cpuinfo');
        foreach (preg_split('/

/', trim($cpuData)) as $cpu) {
            foreach (preg_split('/
/', $cpu) as $line) {
                $parts = array_map('trim', explode(':', $line, 2));
                $cpuInfo[$parts[0]] = isset($parts[1]) ? $parts[1] : null;
            }
        }

        return $cpuInfo;
    }
}

// Example usage of the SystemMonitor class
try {
    $monitor = new SystemMonitor();
    $loadAverages = $monitor->getSystemLoadAverages();
    $memoryUsage = $monitor->getMemoryUsage();
    $diskUsage = $monitor->getDiskUsage();
    $cpuInfo = $monitor->getCpuInfo();

    echo "System Load Averages: ", print_r($loadAverages, true), "\
";
    echo "Memory Usage: ", print_r($memoryUsage, true), "\
";
    echo "Disk Usage: ", print_r($diskUsage, true), "\
";
    echo "CPU Info: ", print_r($cpuInfo, true), "\
";
} catch (Exception $e) {
    echo 'An error occurred during system monitoring: ', $e->getMessage(), "\
";
}
]