# TwitchTV SDK for PHP

> This is unofficial [TwitchTV SDK for PHP](https://github.com/jofner/Twitch-SDK).
SDK is currently under development, so functions, readme and/or examples will
change.

## Development

There is [develop](https://github.com/jofner/Twitch-SDK/tree/develop) branch, which takes place in refactoring existing features.
Because I need to develop SDK and also have it functional, rewriting functions carried out in phases.
If you have questions or suggestions regarding the development of the new version, you can use [Issues](https://github.com/jofner/Twitch-SDK/issues)

## Requirements

TwitchTV SDK for PHP requires PHP 5.3.0 or later with cURL.

## Installation

The best way to install TwitchTV SDK is use [Composer](http://getcomposer.org/).

### Add bundle to your composer.json file

```js
{
    "require": {
        // ..
        "ritero/twitch-sdk": "dev-master"
    }
}
```

### Download the bundle using Composer

```bash
$ composer require ritero/twitch-sdk:dev-master
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
use \ritero\SDK\TwitchTV\TwitchSDK;

$twitch = new TwitchSDK;
...
```

#### Without Autoloader

```php
require '/path/to/libs/ritero/SDK/TwitchTV/TwitchSDK.php';
require '/path/to/libs/ritero/SDK/TwitchTV/TwitchException.php';

use \ritero\SDK\TwitchTV\TwitchSDK;
use \ritero\SDK\TwitchTV\TwitchException;

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

## Licenses

Refer to the LICENSE.md file for license information

## Reference

[TwitchTV SDK](https://github.com/jofner/Twitch-SDK), 
[TwitchTV](http://www.twitch.tv/), 
[TwitchTV API](https://github.com/justintv/Twitch-API), 
[Composer](http://getcomposer.org/)