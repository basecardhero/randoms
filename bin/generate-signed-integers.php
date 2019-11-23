<?php
/**
 * Create a generateSignedIntegers response from random.org.
 *
 * Example:
 *     export RANDOM_ORG_API_KEY=<your_api_key>
 *     php generate-signed-integer.php
 */

require dirname(__DIR__) . '/vendor/autoload.php';

if ('cli' !== php_sapi_name()) {
    echo 'This application must be run on the command line.';
    exit;
}

$apiKey = getenv('RANDOM_ORG_API_KEY');

if (!$apiKey) {
    echo "RANDOM_ORG_API_KEY not set! use 'export RANDOM_ORG_API_KEY=<your api key>' to set the value.";
    exit;
}

$httpClient = new \BaseCardHero\Randoms\HttpClient();
$client = new \BaseCardHero\Randoms\RandomOrg\Client($apiKey, $httpClient);
$response = $client->generateSignedIntegers(5, 1, 5, false, 10, md5(mt_rand()));

var_dump(
    json_decode((string) $response->getBody(), true)
);
