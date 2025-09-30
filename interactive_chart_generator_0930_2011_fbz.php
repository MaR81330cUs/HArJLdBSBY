<?php
// 代码生成时间: 2025-09-30 20:11:39
// 引入ZEND框架相关组件
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

// 定义InteractiveChartGenerator类
class InteractiveChartGenerator {
    
    private $chartData;
    private $chartType;
    private $options;
    
    // 构造函数
    public function __construct($data, $type) {
        $this->chartData = $data;
        $this->chartType = $type;
        $this->options = array(
            'title' => 'Interactive Chart',
            'width' => 800,
            'height' => 600,
            'legend' => 'none'
        );
    }
    
    // 设置图表选项
    public function setOption($key, $value) {
        if (array_key_exists($key, $this->options)) {
            $this->options[$key] = $value;
        } else {
            throw new InvalidArgumentException('Invalid option key.');
        }
    }
    
    // 生成图表HTML代码
    public function generateChart() {
        if (empty($this->chartData) || empty($this->chartType)) {
            throw new InvalidArgumentException('Chart data or type is missing.');
        }
        
        $html = "<div id='chart_div' style='width: {$this->options['width']}px; height: {$this->options['height']}px;'></div>";
        $html .= "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";
        $html .= "<script type='text/javascript'>";
        $html .= "google.charts.load('current', {'packages':['corechart']});";
        $html .= "google.charts.setOnLoadCallback(drawChart);";
        $html .= "function drawChart() {";
        $html .= "var data = new google.visualization.DataTable();";
        $html .= "data.addColumn('string', 'Element');";
        $html .= "data.addColumn('number', 'Value');";
        foreach ($this->chartData as $key => $value) {
            $html .= "data.addRow(['{$key}', {$value}]);";
        }
        $html .= "var chart = new google.visualization.{$this->chartType}(document.getElementById('chart_div'));";
        $html .= "chart.draw(data, {title: '{$this->options['title']}', width: {$this->options['width']}, height: {$this->options['height']}, legend: '{$this->options['legend']}'});";
        $html .= "}";
        $html .= "</script>";
        
        return $html;
    }
}

// 使用示例
try {
    $chartData = array('Element 1' => 10, 'Element 2' => 20, 'Element 3' => 30);
    $chartGenerator = new InteractiveChartGenerator($chartData, 'BarChart');
    $chartGenerator->setOption('title', 'Custom Chart Title');
    echo $chartGenerator->generateChart();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
