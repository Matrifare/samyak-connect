<?php
/**
 * API Service Layer
 * Centralized service for handling external API calls
 * 
 * This class provides a clean abstraction layer for API integration.
 * Replace the mock methods with actual API endpoints when ready.
 */

namespace App\Services;

class ApiService
{
    private string $baseUrl;
    private array $headers;
    private int $timeout;

    public function __construct(string $baseUrl = '', int $timeout = 30)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeout = $timeout;
        $this->headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];
    }

    /**
     * Set authorization header
     */
    public function setAuthToken(string $token): self
    {
        $this->headers[] = "Authorization: Bearer {$token}";
        return $this;
    }

    /**
     * Set custom header
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[] = "{$name}: {$value}";
        return $this;
    }

    /**
     * Make GET request
     */
    public function get(string $endpoint, array $params = []): array
    {
        $url = $this->buildUrl($endpoint, $params);
        return $this->request('GET', $url);
    }

    /**
     * Make POST request
     */
    public function post(string $endpoint, array $data = []): array
    {
        $url = $this->buildUrl($endpoint);
        return $this->request('POST', $url, $data);
    }

    /**
     * Make PUT request
     */
    public function put(string $endpoint, array $data = []): array
    {
        $url = $this->buildUrl($endpoint);
        return $this->request('PUT', $url, $data);
    }

    /**
     * Make DELETE request
     */
    public function delete(string $endpoint, array $data = []): array
    {
        $url = $this->buildUrl($endpoint);
        return $this->request('DELETE', $url, $data);
    }

    /**
     * Build URL with query parameters
     */
    private function buildUrl(string $endpoint, array $params = []): string
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $url;
    }

    /**
     * Execute HTTP request using cURL
     */
    private function request(string $method, string $url, array $data = []): array
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ];

        switch ($method) {
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                break;
            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                break;
            case 'DELETE':
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                if (!empty($data)) {
                    $options[CURLOPT_POSTFIELDS] = json_encode($data);
                }
                break;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'error' => $error,
                'http_code' => 0
            ];
        }

        $decoded = json_decode($response, true);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'data' => $decoded,
            'http_code' => $httpCode
        ];
    }
}
