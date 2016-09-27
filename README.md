[![Latest Stable Version](https://img.shields.io/packagist/v/crazy-max/cws-share-count.svg?style=flat-square)](https://packagist.org/packages/crazy-max/cws-share-count)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/crazy-max/CwsShareCount/master.svg?style=flat-square)](https://travis-ci.org/crazy-max/CwsShareCount)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/crazy-max/CwsShareCount.svg?style=flat-square)](https://scrutinizer-ci.com/g/crazy-max/CwsShareCount)
[![StyleCI](https://styleci.io/repos/10125005/shield?style=flat-square)](https://styleci.io/repos/10125005)
[![Gemnasium](https://img.shields.io/gemnasium/crazy-max/CwsShareCount.svg?style=flat-square)](https://gemnasium.com/github.com/crazy-max/CwsShareCount)

# CwsShareCount

PHP class to get social share count for Delicious, Facebook, Google+, Linkedin, Pinterest, Reddit, StumbleUpon and Twitter.

## Requirements

* PHP >= 5.3.0
* CwsDebug >= 1.8
* CwsCurl >= 1.8
* Enable the [php_curl](http://php.net/manual/en/book.curl.php) extension.

## Installation with Composer

```bash
composer require crazy-max/cws-share-count
```

And download the code:

```bash
composer install # or update
```

## Getting started

See `tests/test.php` file sample to help you.

## Example

![](https://raw.github.com/crazy-max/CwsShareCount/master/example.png)

## Methods

**getAll** - Get all social share count.<br />
**getDeliciousCount** - Get delicious social share count.<br />
**getFacebookCount** - Get facebook social share count.<br />
**getGooglePlusCount** - Get google plus social share count.<br />
**getLinkedinCount** - Get linkedin social share count.<br />
**getPinterestCount** - Get pinterest social share count.<br />
**getRedditCount** - Get reddit social share count.<br />
**getStumbleuponCount** - Get stumbleupon social share count.<br />
**getTwitterCount** - Get twitter social share count.<br />
**getError** - Get the last error.

## License

LGPL. See ``LICENSE`` for more details.

## More infos

http://www.crazyws.fr/dev/classes-php/cwssharecount-recupere-le-nombre-de-partages-pour-reseaux-sociaux-SZXP0.html
