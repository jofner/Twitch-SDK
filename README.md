[![Latest Stable Version](https://poser.pugx.org/ritero/twitch-sdk/v/stable)](https://packagist.org/packages/ritero/twitch-sdk) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/build-status/master) [![Total Downloads](https://poser.pugx.org/ritero/twitch-sdk/downloads)](https://packagist.org/packages/ritero/twitch-sdk) [![Latest Unstable Version](https://poser.pugx.org/ritero/twitch-sdk/v/unstable)](https://packagist.org/packages/ritero/twitch-sdk#dev-develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/?branch=develop) [![Build Status](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/jofner/Twitch-SDK/build-status/develop) [![License](https://poser.pugx.org/ritero/twitch-sdk/license)](https://packagist.org/packages/ritero/twitch-sdk)

# TwitchTV SDK for PHP

> UNMAINTAINED!!! I have no project to build SDK for or test on, so i abandoned this project. I'm sorry for that and i hope someone kind will continue with developing. Maybe another SDK's are around, so try search GitHub for alternative.

> This is unofficial [TwitchTV SDK for PHP](https://github.com/jofner/Twitch-SDK) formerly known as ritero/twitch-sdk

## WARNING BEFORE UPDATING TO 2.* !!!

Version 2.* changed namespace! I know it's not best practice and i'm really sorry, but i have my reasons for that. Thanks for understanding.
Version 2.* has BC breaks and lot of changes. Be careful with updating! Before updating thoroughly examine the changes and adjust your application for modified functions.

## Requirements

TwitchTV SDK for PHP requires PHP 5.3.0 or later with cURL extension enabled.

## Installation

The best way to install TwitchTV SDK is use [Composer](http://getcomposer.org/).

### Download the bundle using Composer

```bash
$ composer require 'jofner/twitch-sdk:2.0.*'
```

The downloaded package includes the `src` directory. This directory contains
the source code of TwitchTV SDK for PHP. This is the only directory
that you will need in order to deploy your application.

## Getting started

Basic functions starts with standard naming policy (user*, channel* etc.) -
`userGet()` for example. Authenticated functions have auth* prefixes,
like `authUserGet()`.

### SDK initialization in your project

#### With autoloader (Frameworks etc.)

```php
use \jofner\SDK\TwitchTV\TwitchSDK;

$twitch = new TwitchSDK;
...
```

#### Without Autoloader

```php
require '/path/to/libs/jofner/SDK/TwitchTV/TwitchSDK.php';
require '/path/to/libs/jofner/SDK/TwitchTV/TwitchSDKException.php';

use \jofner\SDK\TwitchTV\TwitchSDK;
use \jofner\SDK\TwitchTV\TwitchSDKException;

$twitch = new TwitchSDK;
...
```

### Usage

#### Basic usage (public functions only)

```php
$twitch = new TwitchSDK;
$channel = $twitch->channelGet('channelname');
...
```

#### Authenticated functions usage

```php
$twitch_config = array(
    'client_id' => 'your_twitch_app_client_id',
    'client_secret' => 'your_twitch_app_client_secret',
    'redirect_uri' => 'your_twitch_app_redirect_uri',
);

$twitch = new TwitchSDK($twitch_config);
$loginURL = $twitch->authLoginURL('user_read');
...
```

More examples you can find soon at Wiki pages.

### Error: curl SSL certificate problem: self signed certificate in certificate chain

If you getting this error, you have probably out of date CA root certificates.
Be sure you have in your php.ini set path to certificate in curl.cainfo = "..."

You can get cacert.pem from this site https://curl.haxx.se/docs/caextract.html

## Licenses

Refer to the LICENSE.md file for license information

## Reference

[TwitchTV SDK](https://github.com/jofner/Twitch-SDK),
[TwitchTV](http://www.twitch.tv/),
[TwitchTV API](https://github.com/justintv/Twitch-API),
[Composer](http://getcomposer.org/)
