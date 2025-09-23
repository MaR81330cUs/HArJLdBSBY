<?php
// 代码生成时间: 2025-09-23 20:09:26
class JsonDataFormatter
{
    /**
     * Converts an array to JSON format.
     *
     * @param array $data The array to be converted.
     * @return string The JSON formatted string.
     * @throws Exception If the input is not an array.
     */
    public function arrayToJson(array $data)
    {
        if (!is_array($data)) {
            throw new Exception('Input must be an array.');
        }

        return json_encode($data);
    }

    /**
     * Converts JSON to an associative array.
     *
     * @param string $json The JSON string to be converted.
     * @return array The associative array.
     * @throws InvalidArgumentException If the input is not a valid JSON string.
     */
    public function jsonToArray(string $json)
    {
        if (!is_string($json)) {
            throw new InvalidArgumentException('Input must be a string.');
        }

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON string.');
        }

        return $data;
    }
}

/**
 * Usage example:
 *
 * $formatter = new JsonDataFormatter();
 *
 * // Converting array to JSON
 * $array = ['name' => 'John', 'age' => 30];
 * $json = $formatter->arrayToJson($array);
 * echo $json; // Outputs: {"name":"John","age":30}
 *
 * // Converting JSON to array
 * $jsonString = '{"name":"John","age":30}';
 * $array = $formatter->jsonToArray($jsonString);
 * print_r($array); // Outputs: Array ( [name] => John [age] => 30 )
 */