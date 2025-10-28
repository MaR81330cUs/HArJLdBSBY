<?php
// 代码生成时间: 2025-10-28 16:07:37
class DataCompressionUtility {

    /**
     * 使用GZIP压缩数据
     *
     * @param string $data 待压缩的数据
     * @return string 压缩后的GZIP数据
     * @throws Exception 如果压缩失败
     */
    public function compressData($data) {
        $compressedData = gzencode($data);
        if ($compressedData === false) {
            throw new Exception('Data compression failed.');
        }
        return $compressedData;
    }

    /**
     * 使用GZIP解压数据
     *
     * @param string $compressedData 待解压的GZIP数据
     * @return string 解压后的数据
     * @throws Exception 如果解压失败
     */
    public function decompressData($compressedData) {
        $decompressedData = gzdecode($compressedData);
        if ($decompressedData === false) {
            throw new Exception('Data decompression failed.');
        }
        return $decompressedData;
    }

}

/**
 * 使用示例
 */
try {
    // 创建工具实例
    $utility = new DataCompressionUtility();

    // 原始数据
    $originalData = 'This is some test data to be compressed.';

    // 压缩数据
    $compressed = $utility->compressData($originalData);
    echo 'Compressed data: ' . strlen($compressed) . ' bytes' . "
";

    // 解压数据
    $decompressed = $utility->decompressData($compressed);
    echo 'Decompressed data: ' . $decompressed . "
";

} catch (Exception $e) {
    // 错误处理
    echo 'Error: ' . $e->getMessage();
}
