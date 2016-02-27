<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchException;
use jofner\SDK\TwitchTV\TwitchRequest;

/**
 * Users method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class User
{
    /** @var TwitchRequest */
    protected $request;

    const URI_USER = 'users/';
    const URI_USER_AUTH = 'user';
    const URI_STREAMS_FOLLOWED_AUTH = 'streams/followed';
    const URI_VIDEOS_FOLLOWED_AUTH = 'videos/followed';

    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the specified user
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-usersuser
     * @param string $username
     * @return \stdClass
     * @throws TwitchException
     */
    public function getUser($username)
    {
        return $this->request->request(self::URI_USER . $username);
    }

    /**
     * Get the authenticated user
     *  - requires scope 'user_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-user
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getUserAuth($queryString)
    {
        return $this->request->request(self::URI_USER_AUTH . $queryString);
    }

    /**
     * List the live streams that the authenticated user is following
     *  - requires scope 'user_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-streamsfollowed
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getFollowedStreams($queryString)
    {
        return $this->request->request(self::URI_STREAMS_FOLLOWED_AUTH . $queryString);
    }

    /**
     * List of videos that the authenticated user is following
     *  - requires scope 'user_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/users.md#get-videosfollowed
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getFollowedVideos($queryString)
    {
        return $this->request->request(self::URI_VIDEOS_FOLLOWED_AUTH . $queryString);
    }
}
