<?php

namespace BaseCardHero\Randoms\Tests\RandomOrg;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use BaseCardHero\Randoms\HttpClient;
use Psr\Http\Message\ResponseInterface;
use BaseCardHero\Randoms\Tests\TestCase;
use BaseCardHero\Randoms\RandomOrg\Client;
use BaseCardHero\Randoms\RandomOrg\ClientException;

class ClientTest extends TestCase
{
    /** @test */
    public function generateSignedIntegers_will_send_a_httpClient_request_and_return_a_Response()
    {
        $expected = [
            'jsonrpc' => '2.0',
            'method' => 'generateSignedIntegers',
            'params' => [
                'apiKey' => '00000000-0000-0000-0000-0000000000',
                'n' => 32,
                'min' => 1,
                'max' => 32,
                'base' => 10,
                'replacement' => false,
            ],
            'id' => '12345',
        ];

        $client = $this->createClient(
            '00000000-0000-0000-0000-0000000000',
            new Response(200)
        );

        $this->assertInstanceof(
            Response::class,
            $client->generateSignedIntegers(32, 1, 32, false, 10, '12345')
        );
    }

    /** @test */
    public function generateSignedIntegers_will_throw_an_exception_if_random_org_returns_a_json_rpc_error()
    {
        $response_body = json_encode([
            'jsonrpc' => '2.0',
            'error' => [
                'code' => 12,
                'message' => 'The error message',
                'data' => [17, 3],
            ],
            'id' => '12345',
        ]);

        $client = $this->createClient(
            '00000000-0000-0000-0000-0000000000',
            new Response(200, [], $response_body)
        );

        try {
            $response = $client->generateSignedIntegers(32, 1, 32, false, 10, '12345');
        } catch (\Exception $exception) {
            $this->assertEquals('The error message', $exception->getMessage());
            $this->assertEquals(12, $exception->getCode());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /** @test */
    public function getUsage_will_send_a_httpClient_request_and_return_a_Response()
    {
        $response_body = json_encode([
            'jsonrpc' => '2.0',
            'method' => 'getUsage',
            'params' => [
                'apiKey' => '00000000-0000-0000-0000-0000000000',
            ],
            'id' => '12345',
        ]);

        $client = $this->createClient(
            '00000000-0000-0000-0000-0000000000',
            new Response(200, [], $response_body)
        );

        $this->assertInstanceof(
            Response::class,
            $client->getUsage('12345')
        );
    }

    /**
     * Create a Client that will return the ResponseInterface.
     *
     * @param string $apiKey
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \BaseCardHero\Randoms\RandomOrg\Client
     */
    protected function createClient($apiKey, ResponseInterface $response)
    {
        $httpClient = $this->createMockedHttpClient($response);

        return new Client($apiKey, $httpClient);
    }

    /**
     * Create a HttpClient that will return the given a ResponseInterface.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \BaseCardHero\Randoms\HttpClient
     */
    protected function createMockedHttpClient(ResponseInterface $response)
    {
        $handler = HandlerStack::create(new MockHandler([$response]));

        return new HttpClient(['handler' => $handler]);
    }
}
