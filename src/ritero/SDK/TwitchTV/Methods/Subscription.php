<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchException;
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
class Subscription
{
    /** @var TwitchRequest */
    protected $request;

    const URI_CHANNEL_SUBSCRIPTIONS = 'channels/%s/subscriptions';

    public function __construct()
    {
        $this->request = new TwitchRequest;
    }

    /**
     * @description Returns an array of subscriptions who are subscribed to specified channel
     *  - requires scope 'channel_subscriptions'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptions
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getSubscriptions($channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_CHANNEL_SUBSCRIPTIONS, $channel) . $queryString);
    }
}
