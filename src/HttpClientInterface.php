<?php

namespace BaseCardHero\Randoms;

interface HttpClientInterface
{
    /**
     * Perform a http request to the given uri.
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request(string $method, string $uri = '', array $options = []);
}
