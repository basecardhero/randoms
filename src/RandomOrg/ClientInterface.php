<?php

namespace BaseCardHero\Randoms\RandomOrg;

use GuzzleHttp\Psr7\Response;

interface ClientInterface
{
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
    ): Response;

    /**
     * Get the account usage.
     *
     * @param string $id
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function getUsage(string $id): Response;
}
