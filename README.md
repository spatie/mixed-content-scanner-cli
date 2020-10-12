
# A CLI tool to check sites for mixed content

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://packagist.org/packages/spatie/mixed-content-scanner-cli)
[![Build Status](https://img.shields.io/travis/spatie/mixed-content-scanner-cli/master.svg?style=flat-square)](https://travis-ci.org/spatie/mixed-content-scanner-cli)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/34497608-e63b-4814-93ac-f7af4d7a8ffa.svg?style=flat-square)](https://insight.sensiolabs.com/projects/34497608-e63b-4814-93ac-f7af4d7a8ffa)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/mixed-content-scanner-cli)
[![StyleCI](https://styleci.io/repos/98778969/shield?branch=master)](https://styleci.io/repos/98778969)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/mixed-content-scanner-cli.svg?style=flat-square)](https://packagist.org/packages/spatie/mixed-content-scanner-cli)

This repo contains a tool called `mixed-content-scanner` that can help you find pieces of mixed content on your site. This is how you can use it:

```bash
mixed-content-scanner scan https://spatie.be
```

And of course our company site reports no mixed content.

![spatie](https://spatie.github.io/mixed-content-scanner-cli/spatie.jpg)

Here's an example of a local test server that does contain some mixed content:

![mixed](https://spatie.github.io/mixed-content-scanner-cli/mixed.jpg)

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/mixed-content-scanner-cli.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/mixed-content-scanner-cli)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer global require spatie/mixed-content-scanner-cli
```

## How it works under the hood

When scanning a site, the tool will crawl every page. On all html retrieved, these elements and attributes will be checked:

- `audio`: `src`
- `embed`: `src`
- `form`: `action`
- `link`: `href`
- `iframe`: `src`
- `img`: `src`, `srcset`
- `object`: `data`
- `param`: `value`
- `script`: `src`
- `source`: `src`, `srcset`
- `video`: `src`

If any of those attributes start with `http://` the element will be regarded as mixed content.

The tool does not scan linked `.css` or `.js` files. Inline `<script>` or `<style>` are not taken into consideration.

## Usage

You can scan a site by using the `scan` command followed by the url

```bash
mixed-content-scanner scan https://example.com
```

## Options

### SSL verification

You might want to check your site for mixed content before actually launching it.  It's quite common your site doesn't have an ssl certificate installed yet at that point. That's why by default the tool will not verify ssl certificates.

If you want to turn on ssl verification just use the `verify-ssl option`

```bash
mixed-content-scanner scan https://self-signed.badssl.com/ --verify-ssl
```

That examples will result in non responding urls because the host does not have a valid ssl certificate

### Filtering and ignoring urls

You can filter which urls are going to be crawled by passing regex to the `filter` and `ignore` options. 

In this example we are only going to crawl pages starting with `/en`.

```bash
mixed-content-scanner scan https://spatie.be --filter="^\/en"
```

You can use multiple filters:

```bash
mixed-content-scanner scan https://spatie.be --filter="^\/en" --filter="^\/nl"
```

You can also ignore certain urls. Here we are going to ignore all url's that contain the word `opensource`.

```bash
mixed-content-scanner scan https://spatie.be --ignore="opensource"
```

Of course you can also combine filters and ignores:

```bash
mixed-content-scanner scan https://spatie.be --filter="^\/en" --ignore="opensource"
```

### Ignoring robots

By default, the crawler will respect robots data. You can ignore them though with the `--ignore-robots` option.

```bash
mixed-content-scanner scan https://example.com --ignore-robots
```

### Custom User agent
By default, the crawler uses the underlying guzzle client for the user agent. You can override this value with the `--user-agent` option.
```bash
mixed-content-scanner scan https://example.com --user-agent='MyCustomCrawler'
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

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The scanner is inspired by [mixed-content-scan](https://github.com/bramus/mixed-content-scan) by [Bram Van Damme](https://github.com/bramus). Parts of his readme and code were used.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
