<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchSDKException;
use jofner\SDK\TwitchTV\TwitchRequest;

/**
 * Subscription method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
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
     * @throws TwitchSDKException
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
     * @throws TwitchSDKException
     */
    public function getSubscribedUser($channel, $user, $queryString)
    {
        return $this->request->request(sprintf(self::URI_CHANNEL_SUBSCRIPTIONS_USER, $channel, $user) . $queryString);
    }

    /**
     * Returns a channel object that user subscribes to
     *  - requires scope 'user_subscriptions' for user
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-usersusersubscriptionschannel
     * @param string $user
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getSubscribedToChannel($user, $channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_USER_SUBSCRIPTIONS_CHANNEL, $user, $channel) . $queryString);
    }
}
