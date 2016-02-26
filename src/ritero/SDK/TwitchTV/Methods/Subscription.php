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
    const URI_CHANNEL_SUBSCRIPTIONS_USER = 'channels/%s/subscriptions/%s';
    const URI_USER_SUBSCRIPTIONS_CHANNEL = 'users/%s/subscriptions/%s';

    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
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

    /**
     * Returns user object if that user is subscribed
     *  - requires scope 'channel_check_subscription' for channel
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptionsuser
     * @param string $channel
     * @param string $user
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getSubscribedUser($channel, $user, $queryString)
    {
        return $this->request->request(sprintf(self::URI_CHANNEL_SUBSCRIPTIONS_USER, $channel, $user) . $queryString);
    }

    /**
     * Returns a channel object that user subscribes to
     *  - requires scope 'user_subscriptions' for user
     * @param string $user
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getSubscribedToChannel($user, $channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_USER_SUBSCRIPTIONS_CHANNEL, $user, $channel) . $queryString);
    }
}
