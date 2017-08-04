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

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

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

## Additional informations about web application security

The following informations about "Content-Security-Policy" and "Subresource-Integrity" maybe can help you to increase the security of your web application.

### Content-Security-Policy

The new Content-Security-Policy HTTP response header helps you reduce XSS risks on modern browsers by declaring what dynamic resources are allowed to load via a HTTP Header.

Links:
- [content-security-policy.com](http://content-security-policy.com/)
- [html5rocks](http://www.html5rocks.com/en/tutorials/security/content-security-policy/)
- [w3c](https://w3c.github.io/webappsec-csp/)
- [owasp](https://www.owasp.org/index.php/Content_Security_Policy)
- [caniuse](http://caniuse.com/#feat=contentsecuritypolicy)

Tools:
- [SSL Server Test](https://www.ssllabs.com/ssltest/analyze.html)
- [securityheaders.io](https://securityheaders.io)
- [SSL Configuration Generator by Mozilla](https://mozilla.github.io/server-side-tls/ssl-config-generator/)
- [HTTP Observatory by Mozilla](https://observatory.mozilla.org/analyze.html)
- [CSP Header Generator](http://cspisawesome.com/)

#### Content-Security-Policy - Strict-Transport-Security

If a user types `example.com` in their browser, even if the server
redirects them to the secure version of the website, that still leaves
a window of opportunity (the initial HTTP connection) for an attacker
to downgrade or redirect the request.

Links:
- [Strict-Transport-Security](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security)
- [caniuse](http://caniuse.com/#search=strict%20transport%20security)
- [owasp](https://www.owasp.org/index.php/HTTP_Strict_Transport_Security_Cheat_Sheet)

example 1: (.htaccess)
```apache
# The following header ensures that browser will ONLY connect to your
# server via HTTPS, regardless of what the users type in the browser's
# address bar.
#
# (!) Remove the `includeSubDomains` optional directive if the website's
# subdomains are not using HTTPS.

<IfModule mod_headers.c>
    Header always set Strict-Transport-Security "max-age=16070400; includeSubDomains"
</IfModule>
```

example 2: (.htaccess)
```apache
# Cache SSL redirection
#
# Using this header, any browser that accesses the site over HTTPS will not
# be able to access the plain HTTP site for one day (86400 seconds).
# One you begin using this, you should not stop using SSL on your site or
# else your returning visitors will not be able to access your site at all.
#
# (!) Remove the `env=HTTPS` optional directive if you want to force
# HTTP to HTTPS.

<IfModule mod_headers.c>
    Header set Strict-Transport-Security "max-age=86400; includeSubDomains" env=HTTPS
</IfModule>
```

#### Content-Security-Policy - upgrade-insecure-requests

The HTTP Content-Security-Policy (CSP) upgrade-insecure-requests directive instructs user agents to treat all of a site's insecure URLs (those served over HTTP) as though they have been replaced with secure URLs (those served over HTTPS). This directive is intended for web sites with large numbers of insecure legacy URLs that need to be rewritten.

Links:
- [w3c](https://w3c.github.io/webappsec/specs/upgrade/)
- [caniuse](http://caniuse.com/#search=upgrade-insecure-requests)
- [google chrome example](https://googlechrome.github.io/samples/csp-upgrade-insecure-requests/index.html)

example: (.htaccess)
```apache
<IfModule mod_headers.c>
    Header set Content-Security-Policy "upgrade-insecure-requests" env=HTTPS
</IfModule>
```

example: (php)
```php
header('Content-Security-Policy: upgrade-insecure-requests;');
```

#### Content-Security-Policy-Report-Only

WARNING: "Report-Only" is only the first step, it does nothing but reporting ... You need to change our application code so we can increase security by disabling 'unsafe-inline' 'unsafe-eval' directives for css and js.

example: (php)
```php
header("Content-Security-Policy-Report-Only: script-src 'self'; report-uri /content-security-policy-report.php");
```

### Subresource Integrity

Subresource Integrity (SRI) is a security feature that enables browsers to verify that files they fetch (for example, from a CDN) are delivered without unexpected manipulation. It works by allowing you to provide a cryptographic hash that a fetched file must match.

If you are e.g. in a public wlan and there is a simple transparent proxy in the background (on the router for example) which replace "http://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js", then your browser will cache the replaced js-file and will use it e.g. in your local enviroment or on other sites. Also your js-, css-files from your own website (not only from CDN) can be replaced easely if you are not using SSL (or if the user ignore the red-error-page about the SSL-error).

Links:
[Subresource Integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity)
[caniuse](http://caniuse.com/#search=subresource-integrity)

example: (html)
```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
```

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The scanner is inspired by [mixed-content-scan](https://github.com/bramus/mixed-content-scan) by [Bram Van Damme](https://github.com/bramus). Parts of his readme and code were used.

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
