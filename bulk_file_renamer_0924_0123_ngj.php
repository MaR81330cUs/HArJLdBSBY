<?php
// 代码生成时间: 2025-09-24 01:23:38
// bulk_file_renamer.php
// 批量文件重命名工具

require 'vendor/autoload.php'; // 引入Zend框架的自动加载器

use Zend\File\Rename; // 使用Zend框架的文件重命名功能
use Zend\Validator\File\IsImage; // 使用Zend框架的文件验证功能

// 定义批量文件重命名类
class BulkFileRenamer {
    private $sourceDirectory;
    private $targetDirectory;
    private $newFilenamePattern;

    // 构造函数
    public function __construct($sourceDirectory, $targetDirectory, $newFilenamePattern) {
        $this->sourceDirectory = $sourceDirectory;
        $this->targetDirectory = $targetDirectory;
        $this->newFilenamePattern = $newFilenamePattern;
    }

    // 执行批量文件重命名
    public function renameFiles() {
        // 检查源目录和目标目录是否存在
        if (!is_dir($this->sourceDirectory) || !is_dir($this->targetDirectory)) {
            throw new Exception("Source or target directory does not exist.");
        }

        // 获取源目录下所有文件
        $files = scandir($this->sourceDirectory);

        foreach ($files as $file) {
            // 跳过目录和隐藏文件
            if ($file == '.' || $file == '..' || is_dir($this->sourceDirectory . '/' . $file)) {
                continue;
            }

            // 生成新文件名
            $newFilename = sprintf($this->newFilenamePattern, $file);

            // 检查新文件名是否有效
            $isImage = new IsImage();
            if (!$isImage->isValid($newFilename)) {
                throw new Exception("Invalid new filename: {$newFilename}");
            }

            try {
                // 使用Zend框架的文件重命名功能
                $rename = new Rename($this->sourceDirectory . '/' . $file, $this->targetDirectory . '/' . $newFilename);
                $rename->overwrite(true);
                $rename->filter(Rename::DECOUPLE);
                $rename->filter(Rename::TRANSLATE);
                $rename->execute();
            } catch (Exception $e) {
                // 处理重命名失败的情况
                error_log("Failed to rename {$file} to {$newFilename}: {$e->getMessage()}", 0);
            }
        }
    }
}

// 示例用法
try {
    $sourceDir = "/path/to/source";
    $targetDir = "/path/to/target";
    $newFilenamePattern = "new_%s"; // 新文件名格式，%s表示原文件名

    $renamer = new BulkFileRenamer($sourceDir, $targetDir, $newFilenamePattern);
    $renamer->renameFiles();
    echo "Files renamed successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
