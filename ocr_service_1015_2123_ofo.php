<?php
// 代码生成时间: 2025-10-15 21:23:48
use ZendService\Google\CaptchaResponse;
use ZendService\Google\Exception;

/**
 * OCR Service class
 */
class OcrService {
    private $clientId;
    private $clientSecret;
    private $apiUrl;
    private $apiKey;

    // Constructor to initialize the service with necessary credentials
    public function __construct($clientId, $clientSecret, $apiKey) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiUrl = 'https://vision.googleapis.com/v1/images:annotate';
        $this->apiKey = $apiKey;
    }

    /**
     * Perform OCR on an image file
     *
     * @param string $imagePath Path to the image file
     * @return array OCR results or error message
     */
    public function performOcr($imagePath) {
        try {
            // Check if the image file exists
            if (!file_exists($imagePath)) {
                throw new Exception('Image file not found.');
            }

            // Read the image content
            $imageData = file_get_contents($imagePath);
            $encodedImageData = base64_encode($imageData);

            // Prepare the request payload
            $payload = [
                'requests' => [
                    [
                        'image' => ['content' => $encodedImageData],
                        'features' => [
                            ['type' => 'TEXT_DETECTION']
                        ]
                    ]
                ]
            ];

            // Perform the API request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ]);

            $response = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Check if the response is successful
            if ($responseCode != 200) {
                throw new Exception('OCR API call failed with code: ' . $responseCode);
            }

            // Decode the response and return the results
            $decodedResponse = json_decode($response, true);
            if (isset($decodedResponse['responses'])) {
                return $decodedResponse['responses'][0]['fullTextAnnotation']['text'];
            } else {
                throw new Exception('No OCR results found.');
            }
        } catch (Exception $e) {
            // Handle exceptions and return error messages
            return ['error' => $e->getMessage()];
        }
    }
}

/**
 * Example usage of the OcrService class
 */
try {
    $ocrService = new OcrService('YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET', 'YOUR_API_KEY');
    $ocrResults = $ocrService->performOcr('/path/to/image.jpg');
    echo '<pre>' . print_r($ocrResults, true) . '</pre>';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
