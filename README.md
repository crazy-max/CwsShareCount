[![Build Status](https://travis-ci.org/crazy-max/CwsShareCount.svg?branch=master)](https://travis-ci.org/crazy-max/CwsShareCount) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/crazy-max/CwsShareCount/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/crazy-max/CwsShareCount/?branch=master)

# CwsShareCount

PHP class to get social share count for Delicious, Facebook, Google+, Linkedin, Pinterest, Reddit, StumbleUpon and Twitter.

## Requirements

* PHP >= 5.3
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
