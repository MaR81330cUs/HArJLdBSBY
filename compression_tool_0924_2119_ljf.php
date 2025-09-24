<?php
// 代码生成时间: 2025-09-24 21:19:41
class CompressionTool {

    /**
     * @var string The path where files will be compressed or decompressed.
     */
    private $path;

    /**
     * Constructor for the CompressionTool class.
     *
     * @param string $path The base path where files will be handled.
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * Compress a file or directory into a zip archive.
     *
     * @param string $source Path to the file or directory to compress.
     * @param string $destination Path to the resulting zip file.
     * @return boolean True on success, false on failure.
     */
    public function compress($source, $destination) {
        try {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZipArchive::CREATE) !== TRUE) {
                throw new Exception("Cannot open zip archive: {$destination}");
            }
            if (is_dir($source)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($source),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($source) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            } else {
                $zip->addFile($source, basename($source));
            }
            $zip->close();
            return true;
        } catch (Exception $e) {
            // Log error message
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Decompress a zip archive to a specified directory.
     *
     * @param string $source Path to the zip file to decompress.
     * @param string $destination Path to the directory where files will be extracted.
     * @return boolean True on success, false on failure.
     */
    public function decompress($source, $destination) {
        try {
            $zip = new ZipArchive();
            if ($zip->open($source) !== TRUE) {
                throw new Exception("Cannot open zip archive: {$source}");
            }
            $zip->extractTo($destination);
            $zip->close();
            return true;
        } catch (Exception $e) {
            // Log error message
            error_log($e->getMessage());
            return false;
        }
    }
}

// Example usage
try {
    $path = "/path/to/files";
    $compressionTool = new CompressionTool($path);
    
    // Compress
    $compressResult = $compressionTool->compress("{$path}/to/compress", "{$path}/compressed.zip");
    if ($compressResult) {
        echo "Compression successful.
";
    } else {
        echo "Compression failed.
";
    }
    
    // Decompress
    $decompressResult = $compressionTool->decompress("{$path}/compressed.zip", "{$path}/decompressed");
    if ($decompressResult) {
        echo "Decompression successful.
";
    } else {
        echo "Decompression failed.
";
    }
} catch (Exception $e) {
    // Handle general exceptions
    echo "An error occurred: " . $e->getMessage();
}
