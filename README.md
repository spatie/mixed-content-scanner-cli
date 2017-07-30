**WORK IN PROGRESS, DO NOT USE YET**

# A cli tool to check sites for mixed content

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://packagist.org/packages/spatie/mixed-content-scanner-cli)
[![Build Status](https://img.shields.io/travis/spatie/mixed-content-scanner-cli/master.svg?style=flat-square)](https://travis-ci.org/spatie/mixed-content-scanner-cli)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/mixed-content-scanner-cli)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://packagist.org/packages/spatie/mixed-content-scanner-cli)

This repo contains a tool called `mixed-content-scanner` that can help you find pieces of mixed content on your site. This is how you can use it:

```bash
mixed-content-scanner scan https://spatie.be
```

And of course our company site reports no mixed content.

[TO DO: add image]

Here's an example of a local test server that does contain some mixed content

[TO DO: add image]

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Installation

**Note:** Remove this paragraph if you are building a public package  
This package is custom built for [Spatie](https://spatie.be) projects and is therefore not registered on packagist. In order to install it via composer you must specify this extra repository in `composer.json`:

```json
"repositories": [ { "type": "composer", "url": "https://satis.spatie.be/" } ]
```

You can install the package via composer:

```bash
composer require spatie/mixed-content-scanner-cli
```

## Usage

``` php
$skeleton = new Spatie\Skeleton();
echo $skeleton->echoPhrase('Hello, Spatie!');
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
