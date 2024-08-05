<?php
#Define the HTTP Client Interface
interface HttpClientInterface {
    public function get(string $url): string;
    public function post(string $url, array $data): string;
    public function put(string $url, array $data): string;
    public function delete(string $url): string;
}

#Create Traits for Reusable Methods

trait HttpRequestTrait {

    protected function sendRequest(string $method, string $url, array $data = []): string {
        // Here you would use cURL or any other method to send the HTTP request
        // This is a simplified example.
        return "Sending $method request to $url with data: " . json_encode($data);
    }

     protected function handleResponse(string $response): array {
            // Here you would handle the response, for instance, decode JSON, handle errors, etc.
            return json_decode($response, true);
     }

}

#Implement the Interface in Concrete Classes
class CurlHttpClient implements HttpClientInterface {
    use HttpRequestTrait;

    public function get(string $url): string {
        $response = $this->sendRequest('GET', $url);
        return $response;
    }

    public function post(string $url, array $data): string {
        $response = $this->sendRequest('POST', $url, $data);
        return $response;
    }

    public function put(string $url, array $data): string {
        $response = $this->sendRequest('PUT', $url, $data);
        return $response;
    }

    public function delete(string $url): string {
        $response = $this->sendRequest('DELETE', $url);
        return $response;
    }
}

class GuzzleHttpClient implements HttpClientInterface {
    use HttpRequestTrait;

    public function get(string $url): string {
        $response = $this->sendRequest('GET', $url);
        return $response;
    }

    public function post(string $url, array $data): string {
        $response = $this->sendRequest('POST', $url, $data);
        return $response;
    }

    public function put(string $url, array $data): string {
        $response = $this->sendRequest('PUT', $url, $data);
        return $response;
    }

    public function delete(string $url): string {
        $response = $this->sendRequest('DELETE', $url);
        return $response;
    }
}


$httpClient = new CurlHttpClient();
$response = $httpClient->get('https://example.com');
echo $response;

$httpClient = new GuzzleHttpClient();
$response = $httpClient->post('https://example.com', ['key' => 'value']);
echo $response;

