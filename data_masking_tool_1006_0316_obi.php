<?php
// 代码生成时间: 2025-10-06 03:16:24
// DataMaskingTool.php
// 该工具用于实现数据脱敏功能，帮助保护敏感信息

class DataMaskingTool {

    private $maskingConfig;

    // 构造函数，接收脱敏配置
    public function __construct(array $maskingConfig) {
        $this->maskingConfig = $maskingConfig;
    }

    // 脱敏数据
    public function maskData($data) {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Data must be an array');
        }

        try {
            foreach ($data as $key => $value) {
                // 检查配置中是否有指定的脱敏规则
                if (array_key_exists($key, $this->maskingConfig) && !empty($this->maskingConfig[$key])) {
                    // 应用脱敏规则
                    $data[$key] = $this->applyMaskingRule($value, $this->maskingConfig[$key]);
                }
            }
        } catch (Exception $e) {
            // 错误处理
            throw new Exception('Error masking data: ' . $e->getMessage());
        }

        return $data;
    }

    // 应用脱敏规则
    private function applyMaskingRule($value, $rule) {
        // 根据规则类型应用不同的脱敏逻辑
        switch ($rule['type']) {
            case 'email':
                return $this->maskEmail($value);
            case 'phone':
                return $this->maskPhone($value);
            case 'ssn':
                return $this->maskSSN($value);
            // 可以根据需要添加更多规则
            default:
                return $value;
        }
    }

    // 脱敏Email地址
    private function maskEmail($email) {
        return substr($email, 0, 2) . '***' . substr($email, -2);
    }

    // 脱敏电话号码
    private function maskPhone($phone) {
        return substr($phone, 0, 3) . '***' . substr($phone, -4);
    }

    // 脱敏社会安全号码
    private function maskSSN($ssn) {
        return substr($ssn, 0, 3) . '***-***-' . substr($ssn, -4);
    }

}

// 使用示例
try {
    $config = [
        'email' => ['type' => 'email'],
        'phone' => ['type' => 'phone'],
        'ssn' => ['type' => 'ssn']
    ];
    $tool = new DataMaskingTool($config);
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '1234567890',
        'ssn' => '123-45-6789'
    ];
    $maskedData = $tool->maskData($data);
    print_r($maskedData);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
