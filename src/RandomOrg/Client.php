<?php declare(strict_types=1);

namespace BaseCardHero\Randoms\RandomOrg;

use GuzzleHttp\Psr7\Response;
use BaseCardHero\Randoms\HttpClientInterface;

class Client implements ClientInterface
{
    /**
     * The API url.
     *
     * @var string
     */
    protected $apiUrl = 'https://api.random.org/json-rpc/2/invoke';

    /**
     * Random.org API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Underlaying http client.
     *
     * @var \BaseCardHero\Randoms\HttpClientInterface
     */
    protected $httpClient;

    /**
     * Set api key and http client on create.
     *
     * @param \BaseCardHero\Randoms\HttpClientInterface $httpClient
     */
    public function __construct(string $apiKey, HttpClientInterface $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
    }

    /**
     * Generate a random set of signed integers.
     *
     * @param int $count
     * @param int $min
     * @param int $max
     * @param boolean $replacement
     * @param string $id
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function generateSignedIntegers(
        int $count,
        int $min,
        int $max,
        bool $replacement = true,
        int $base = 10,
        string $id = null
    ): Response {
        $parameters = $this->generateSignedIntegersPayload(
            $count,
            $min,
            $max,
            $replacement,
            $base,
            $id
        );

        return $this->httpClient->request('POST', $this->apiUrl, [
            'json' => $parameters,
        ]);
    }

    /**
     * Get the account usage.
     *
     * @param string $id
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function getUsage(string $id): Response
    {
        return $this->httpClient->request('POST', $this->apiUrl, [
            'json' => $this->generateGetUsagePayload($id),
        ]);
    }

    /**
     * Generate a generateSignedIntegers JSON-RPC payload.
     *
     * @param int $count
     * @param int $min
     * @param int $max
     * @param bool $replacement
     * @param int $base
     * @param string $id
     *
     * @return array
     */
    protected function generateSignedIntegersPayload(
        int $count,
        int $min,
        int $max,
        bool $replacement,
        int $base,
        string $id
    ): array {
        $params = [
            'apiKey' => $this->apiKey,
            'n' => $count,
            'min' => $min,
            'max' => $max,
            'base' => $base,
            'replacement' => $replacement,
        ];

        return $this->generateJsonRPCPayload('generateSignedIntegers', $params, $id);
    }

    /**
     * Generate a getUsage JSON-RPC payload.
     *
     * @param string $id
     *
     * @return array
     */
    protected function generateGetUsagePayload(string $id): array
    {
        $params = [
            'apiKey' => $this->apiKey,
        ];

        return $this->generateJsonRPCPayload('getUsage', $params, $id);
    }

    /**
     * Generate a JSON-RPC payload.
     *
     * @param string $method
     * @param array $params
     * @param string $id
     *
     * @return array
     */
    protected function generateJsonRPCPayload(string $method, array $params, string $id): array
    {
        return [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $params,
            'id' => $id,
        ];
    }
}
