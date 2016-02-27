<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchRequest;
use jofner\SDK\TwitchTV\TwitchException;

/**
 * Follow method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Follow
{
    /** @var TwitchRequest */
    protected $request;

    const URI_CHANNEL_FOLLOWS = 'channels/%s/follows';
    const URI_USER_FOLLOWS_CHANNEL = '/users/%s/follows/channels';
    const URI_USER_FOLLOW_RELATION = '/users/%s/follows/channels/%s';

    /**
     * Follow constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a list of follow objects
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-channelschannelfollows
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getChannelFollows($channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_CHANNEL_FOLLOWS, $channel) . $queryString);
    }

    /**
     * Get a user's list of followed channels
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-usersuserfollowschannels
     * @param $user
     * @param $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function userFollowChannels($user, $queryString)
    {
        return $this->request->request(sprintf(self::URI_USER_FOLLOWS_CHANNEL, $user) . $queryString);
    }

    /**
     * Returns 404 Not Found if :user is not following :target. Returns a follow object otherwise
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#get-usersuserfollowschannelstarget
     * @param string $user
     * @param string $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function userIsFollowingChannel($user, $channel)
    {
        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel));
    }

    /**
     * Set user to follow given channel
     *  - requires scope 'user_follows_edit'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#put-usersuserfollowschannelstarget
     * @param string $user
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function followChannel($user, $channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel) . $queryString, 'PUT');
    }

    /**
     * Set user to unfollow given channel
     *  - requires scope 'user_follows_edit'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md#delete-usersuserfollowschannelstarget
     * @param string $user
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function unfollowChannel($user, $channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel) . $queryString, 'DELETE');
    }
}
