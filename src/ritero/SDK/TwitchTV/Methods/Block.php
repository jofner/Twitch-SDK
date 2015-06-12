<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;

/**
 * TwitchTV API SDK for PHP
 *
 * Subscription method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Block
{
    /** @var \ritero\SDK\TwitchTV\TwitchRequest */
    protected $request;

    public function __construct()
    {
        $this->request = new TwitchRequest;
    }
}
