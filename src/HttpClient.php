<?php

namespace ForwardForce\RightSignature;

use ForwardForce\RightSignature\Traits\Pagable;
use ForwardForce\RightSignature\Traits\Parametarable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    use Pagable;
    use Parametarable;

    public const API_VERSION = 'v1';
    public const BASE_URL = 'https://api.rightsignature.com/public/';

    /**
     * Guzzle Client
     *
     * @var Client
     */
    protected Client $client;

    /**
     * The API response
     *
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * Num of results returned by the API call
     *
     * @var int
     */
    private int $found;

    public function __construct(string $apiKey)
    {
        $encodedToken = base64_encode($apiKey);
        $this->client = new Client(
            [
                'base_uri' => self::BASE_URL . '/', 'headers' => ['Authorization:Basic ' => $encodedToken]
            ]
        );
    }

    /**
     * Send get request
     *
     * @param  string $endpoint
     * @return array
     * @throws GuzzleException
     */
    public function get(string $endpoint): array
    {
        $this->response = $this->client->get($endpoint);
        return $this->toArray();
    }

    /**
     * Num of results returned by the API call
     *
     * @return int
     */
    public function count(): int
    {
        return $this->found;
    }

    /**
     * Parse response
     *
     * @return array
     */
    private function toArray(): array
    {
        $response = json_decode($this->response->getBody()->getContents(), true);

        if (empty($response)) {
            return [];
        }

        unset($response['meta']);
        return reset($response);
    }

    /**
     * Add query parameters city endpoint
     *
     * @param  string $endpoint
     * @return string
     */
    protected function buildQuery(string $endpoint): string
    {
        $endpoint = self::API_VERSION . $endpoint;
        if (empty($this->getQueryString())) {
            return $endpoint;
        }

        return $endpoint . '/?' . http_build_query($this->getQueryString());
    }
}
