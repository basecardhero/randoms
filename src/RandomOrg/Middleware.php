<?php declare(strict_types=1);

namespace BaseCardHero\Randoms\RandomOrg;

use Psr\Http\Message\ResponseInterface;

class Middleware
{
    /**
     * Middleware that checks for json-rpc error in response.
     *
     * @return callable Returns a function that accepts the next handler.
     */
    public static function randomOrgErrors(): callable
    {
        return function (callable $handler) {
            return function ($request, array $options) use ($handler) {
                return $handler($request, $options)->then(
                    function (ResponseInterface $response) {
                        $json_body = json_decode((string) $response->getBody(), true);

                        if (isset($json_body['error'])) {
                            throw new RandomOrgException(
                                $json_body['error']['message'],
                                $json_body['error']['code']
                            );
                        }

                        return $response;
                    }
                );
            };
        };
    }
}
