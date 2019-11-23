# BaseCardHero - Randoms

_This package was created for a project I am working on and does not fully support random.org services (or the way you may want it to). Feel free to add functionality by creating a pull request. See [contributing](CONTRIBUTING.md)._

## Installation

You can install the package via [composer](https://getcomposer.org/):

``` bash
$ composer require basecardhero/randoms
```

## Usage

You will need to configure the [Random.org API Key](https://api.random.org/).

### Examples

#### Create a client instance

``` php
require_once '/project/path/vendor/autoload.php';

$apiKey = '00000000-0000-0000-0000-0000000000';
$httpClient = new \GuzzleHttp\Client();
$randomOrgClient = new \BaseCardHero\Randoms\RandomOrg\Client($apiKey, $httpClient);
```

#### generateSignedIntegers

``` php
$response = $randomOrgClient->generateSignedIntegers(5, 0, 4, false, 10, 'some-id');
echo get_class($response); // \Psr\Http\Message\ResponseInterface
```

You can get the json response with the following.
``` php
$json_response = json_decode((string) $response->getBody(), true);
```
See [generateSignedIntegers](https://api.random.org/json-rpc/2/signed) for the respons structure.

#### getUsage

``` php
$response = $randomOrgClient->getUsage('some-id');
echo get_class($response); // \Psr\Http\Message\ResponseInterface
```

You can get the json response with the following.
``` php
$json_response = json_decode((string) $response->getBody(), true);
```
See [getUsage](https://api.random.org/json-rpc/2/signed) for the respons structure.

### Command line examples

Before using the command line examples, be sure to set your api key.

``` bash
export RANDOM_ORG_API_KEY=00000000-0000-0000-0000-0000000000
```

#### generateSignedIntegers

``` bash
php bin/generate-signed-integers.php
```

#### getUsage

``` bash
php bin/get-usage.php
```

### Testing

``` bash
composer all
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ryan@basecardhero.com instead of using the issue tracker.

### Credits

- [Base Card Hero](https://github.com/basecardhero) | [basecardhero.com](https://basecardhero.com/)
- [All Contributors](../../contributors)

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

### PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
