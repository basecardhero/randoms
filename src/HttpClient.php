<?php declare(strict_types=1);

namespace BaseCardHero\Randoms;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use BaseCardHero\Randoms\RandomOrg\Middleware;

class HttpClient extends GuzzleClient implements HttpClientInterface
{
    /**
     * Override of GuzzleHttp\Client::_construct().
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['handler'])) {
            $config['handler'] = HandlerStack::create();
        }

        $config['handler']->push(Middleware::randomOrgErrors(), 'random_org_errors');

        parent::__construct($config);
    }
}
