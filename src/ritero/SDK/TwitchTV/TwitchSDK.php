<?php

namespace ritero\SDK\TwitchTV;

use ritero\SDK\TwitchTV\Methods;

/**
 * TwitchTV API SDK for PHP
 *
 * PHP SDK for interacting with the TwitchTV API
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 * @version 2.0.0-dev
 */
class TwitchSDK
{
    /**
     * @var array|bool
     * @todo Create setter and getter with data validation
     */
    protected $authConfig = false;

    /** @var TwitchRequest */
    protected $request;

    /** @var Helper */
    protected $helper;

    /**
     * TwitchAPI URI's
     */
    const URL_TWITCH = 'https://api.twitch.tv/kraken/';
    const URL_TWITCH_TEAM = 'http://api.twitch.tv/api/team/';
    const URI_USER_FOLLOWS_CHANNEL = '/users/%s/follows/channels';
    const URI_USER_FOLLOW_RELATION = '/users/%s/follows/channels/%s';
    const URI_CHANNEL = 'channels/';
    const URI_CHANNEL_FOLLOWS = 'channels/%s/follows';
    const URI_STREAM = 'streams/';
    const URI_STREAM_SUMMARY = 'streams/summary/';
    const URI_STREAMS_FEATURED = 'streams/featured/';
    const URI_STREAMS_SEARCH = 'search/streams/';
    const URI_VIDEO = 'videos/';
    const URI_CHAT = 'chat/';
    const URI_CHAT_EMOTICONS = 'chat/emoticons';
    const URI_GAMES_TOP = 'games/top/';
    const URI_TEAMS = 'teams/';
    const API_VERSION = 2;
    const MIME_TYPE = 'application/vnd.twitchtv.v%d+json';

    /**
     * TwitchSDK constructor
     * @param array $config
     * @throws TwitchException
     */
    public function __construct(array $config = array())
    {
        if (!in_array('curl', get_loaded_extensions())) {
            throw new TwitchException('cURL extension is not installed and is required');
        }

        if (count($config) > 0) {
            $this->setAuthConfig($config);
        }

        /**
         * Develop workaround for requests
         * @todo class calls refactoring needed for future use
         */
        $this->request = new TwitchRequest;
        $this->helper = new Helper;
    }

    /**
     * authConfig setter
     * @param array $config
     * @return TwitchSDK
     * @throws TwitchException
     */
    public function setAuthConfig(array $config)
    {
        if ($this->configValidate($config) === true) {
            $this->authConfig = $config;
        } else {
            throw new TwitchException('Wrong Twitch API config parameters');
        }

        return $this;
    }

    /**
     * Basic information about the API and authentication status
     * @param null $token
     * @return \stdClass
     * @throws TwitchException
     */
    public function status($token = null)
    {
        $auth = null;

        if ($token !== null) {
            if ($this->authConfig === false) {
                $this->authConfigException();
            } else {
                $auth = $this->helper->buildQueryString(array('oauth_token' => $token));
            }
        }

        return $this->request->request($auth);
    }

    /**
     * Get the specified user
     * @param $username
     * @return \stdClass
     * @throws TwitchException
     */
    public function userGet($username)
    {
        $user = new Methods\User($this->request);
        return $user->getUser($username);
    }

    /**
     * Get a user's list of followed channels
     * @param $user
     * @param null $limit
     * @param null $offset
     * @return \stdClass
     * @throws TwitchException
     */
    public function userFollowChannels($user, $limit = null, $offset = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        return $this->request->request(sprintf(self::URI_USER_FOLLOWS_CHANNEL, $user) . $queryString);
    }

    /**
     * Get the status of a follow relationship
     * @param $user
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function userFollowRelationship($user, $channel)
    {
        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel));
    }

    /**
     * Set user to follow given channel
     * @param $user
     * @param $channel
     * @param $userToken
     * @return \stdClass
     * @throws TwitchException
     */
    public function userFollowChannel($user, $channel, $userToken)
    {
        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $userToken,
        ));

        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel) . $queryString, 'PUT');
    }

    /**
     * Set user to unfollow given channel
     * @param $user
     * @param $channel
     * @param $userToken
     * @return \stdClass
     * @throws TwitchException
     */
    public function userUnfollowChannel($user, $channel, $userToken)
    {
        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $userToken,
        ));

        return $this->request->request(sprintf(self::URI_USER_FOLLOW_RELATION, $user, $channel) . $queryString, 'DELETE');
    }

    /**
     * Get the specified channel
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function channelGet($channel)
    {
        return $this->request->request(self::URI_CHANNEL . $channel);
    }

    /**
     * Get the specified team
     * @param $teamName
     * @return \stdClass
     * @throws TwitchException
     */
    public function teamGet($teamName)
    {
        return $this->request->request(self::URI_TEAMS . $teamName);
    }

    /**
     * Get all team members
     * @param $teamName
     * @return mixed
     * @throws TwitchException
     */
    public function teamMembersAll($teamName)
    {
        return $this->request->teamRequest($teamName . '/all_channels')->channels;
    }

    /**
     * Returns an array of users who follow the specified channel
     * @param $channel
     * @param null $limit
     * @param null $offset
     * @return \stdClass
     * @throws TwitchException
     */
    public function channelFollows($channel, $limit = null, $offset = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        return $this->request->request(sprintf(self::URI_CHANNEL_FOLLOWS, $channel) . $queryString);
    }

    /**
     * Get the specified channel's stream
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function streamGet($channel)
    {
        return $this->request->request(self::URI_STREAM . $channel);
    }

    /**
     * Search live streams
     * @param $query
     * @param null $limit
     * @param null $offset
     * @return \stdClass
     * @throws TwitchException
     */
    public function streamSearch($query, $limit = null, $offset = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'query' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ));

        return $this->request->request(self::URI_STREAMS_SEARCH . $queryString);
    }

    /**
     * Summarize streams
     * @param null $game
     * @param array|null $channels
     * @param null $hls
     * @return \stdClass
     * @throws TwitchException
     */
    public function streamsSummarize($game = null, array $channels = null, $hls = null)
    {
        if (!empty($channels)) {
            $channels = implode(',', $channels);
        }

        $queryString = $this->helper->buildQueryString(array(
            'game' => $game,
            'channel' => $channels,
            'hls' => $hls,
        ));

        return $this->request->request(self::URI_STREAM_SUMMARY . $queryString);
    }

    /**
     * Get featured streams
     * @param null $limit
     * @param null $offset
     * @param null $hls
     * @return \stdClass
     * @throws TwitchException
     */
    public function streamsFeatured($limit = null, $offset = null, $hls = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
            'hls' => $hls,
        ));

        return $this->request->request(self::URI_STREAMS_FEATURED . $queryString);
    }

    /**
     * Get streams by channel
     * @param $channels
     * @param null $limit
     * @param null $offset
     * @param null $embeddable
     * @param null $hls
     * @return \stdClass
     */
    public function streamsByChannels($channels, $limit = null, $offset = null, $embeddable = null, $hls = null)
    {
        $channelsString = implode(',', $channels);

        return $this->getStreams(null, $limit, $offset, $channelsString, $embeddable, $hls);
    }

    /**
     * Get streams by game
     * @param $game
     * @param null $limit
     * @param null $offset
     * @param null $embeddable
     * @param null $hls
     * @return \stdClass
     */
    public function streamsByGame($game, $limit = null, $offset = null, $embeddable = null, $hls = null)
    {
        return $this->getStreams($game, $limit, $offset, null, $embeddable, $hls);
    }

    /**
     * Get video
     * @param $video
     * @return \stdClass
     * @throws TwitchException
     */
    public function videoGet($video)
    {
        return $this->request->request(self::URI_VIDEO . $video);
    }

    /**
     * Get videos for a channel
     * @param $channel
     * @param null $limit
     * @param null $offset
     * @return \stdClass
     * @throws TwitchException
     */
    public function videosByChannel($channel, $limit = null, $offset = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        return $this->request->request(self::URI_CHANNEL . $channel . '/' . self::URI_VIDEO . $queryString);
    }

    /**
     * Get the specified channel's chat
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function chatGet($channel)
    {
        return $this->request->request(self::URI_CHAT . $channel);
    }

    /**
     * Get a chat's emoticons
     * @return \stdClass
     * @throws TwitchException
     */
    public function chatEmoticons()
    {
        return $this->request->request(self::URI_CHAT_EMOTICONS);
    }

    /**
     * Get top games
     * @param null $limit
     * @param null $offset
     * @return \stdClass
     * @throws TwitchException
     */
    public function gamesTop($limit = null, $offset = null)
    {
        $queryString = $this->helper->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        return $this->request->request(self::URI_GAMES_TOP . $queryString);
    }

    /**
     * Get HTML code for stream embedding
     * @param $channel
     * @param int $width
     * @param int $height
     * @param int $volume
     * @return string
     */
    public function embedStream($channel, $width = 620, $height = 378, $volume = 25)
    {
        return '<object type="application/x-shockwave-flash"
                height="' . $height . '"
                width="' . $width . '"
                id="live_embed_player_flash"
                data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=' . $channel . '"
                bgcolor="#000000">
                <param  name="allowFullScreen"
                    value="true" />
                <param  name="allowScriptAccess"
                    value="always" />
                <param  name="allowNetworking"
                    value="all" />
                <param  name="movie"
                    value="http://www.twitch.tv/widgets/live_embed_player.swf" />
                <param  name="flashvars"
                    value="hostname=www.twitch.tv&channel=' . $channel . '&auto_play=true&start_volume=' . $volume . '" />
                </object>';
    }

    /**
     * Get HTML code for video embedding
     * @param $channel
     * @param $chapterid
     * @param int $width
     * @param int $height
     * @param int $volume
     * @return string
     */
    public function embedVideo($channel, $chapterid, $width = 400, $height = 300, $volume = 25)
    {
        return '<object bgcolor="#000000"
                    data="http://www.twitch.tv/widgets/archive_embed_player.swf"
                    width="' . $width . '"
                    height="' . $height . '"
                    id="clip_embed_player_flash"
                    type="application/x-shockwave-flash">
                <param  name="movie"
                    value="http://www.twitch.tv/widgets/archive_embed_player.swf" />
                <param  name="allowScriptAccess"
                    value="always" />
                <param  name="allowNetworking"
                    value="all" />
                <param name="allowFullScreen"
                    value="true" />
                <param  name="flashvars"
                    value="channel=' . $channel . '&start_volume=' . $volume . '&auto_play=false&chapter_id=' . $chapterid . '" />
                </object>';
    }

    /**
     * Get HTML code for chat embedding
     * @param $channel
     * @param int $width
     * @param int $height
     * @return string
     */
    public function embedChat($channel, $width = 400, $height = 300)
    {
        return '<iframe frameborder="0"
                    scrolling="no"
                    id="chat_embed"
                    src="http://twitch.tv/chat/embed?channel=' . $channel . '&amp;popout_chat=true"
                    height="' . $height . '"
                    width="' . $width . '">
                </iframe>';
    }

    /**
     * Get login URL for authentication
     * @param string $scope Specify which permissions your app requires (space separated list)
     * @return string
     * @throws TwitchException
     */
    public function authLoginURL($scope)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'response_type' => 'code',
            'client_id' => $this->authConfig['client_id'],
            'redirect_uri' => $this->authConfig['redirect_uri'],
            'scope' => $scope,
        ));

        $auth = new Methods\Auth;

        return $auth->getLoginURL($queryString);
    }

    /**
     * Get authentication access token
     * @param string $code returned after app authorization by user
     * @return \stdClass
     * @throws TwitchException
     */
    public function authAccessTokenGet($code)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'client_id' => $this->authConfig['client_id'],
            'client_secret' => $this->authConfig['client_secret'],
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->authConfig['redirect_uri'],
            'code' => $code,
        ));

        $auth = new Methods\Auth;

        return $auth->getAccessToken($queryString);
    }

    /**
     * Get the authenticated user
     *  - requires scope 'user_read'
     * @param string
     * @return \stdClass
     * @throws TwitchException
     */
    public function authUserGet($token)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
        ));

        $user = new Methods\User($this->request);
        return $user->getUserAuth($queryString);
    }

    /**
     * Get the authenticated channel
     *  - requires scope 'channel_read'
     * @param string
     * @return \stdClass
     * @throws TwitchException
     */
    public function authChannelGet($token)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
        ));

        $channels = new Methods\Channel;

        return $channels->getChannel($queryString);
    }

    /**
     * Returns an array of users who are editors of specified channel
     *  - requires scope 'channel_read'
     * @param string
     * @param string
     * @return \stdClass
     * @throws TwitchException
     */
    public function authChannelEditors($token, $channel)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
        ));

        $channels = new Methods\Channel;

        $channels->getEditors($channel, $queryString);
    }

    /**
     * Returns an array of subscriptions who are subscribed to specified channel
     *  - requires scope 'channel_subscriptions'
     * @param string $token - user's access token
     * @param string $channel
     * @param integer $limit - can be up to 100
     * @param integer $offset
     * @param string $direction can be DESC|ASC, if DESC - lasts will be showed first
     * @return \stdClass
     * @throws TwitchException
     */
    public function authChannelSubscriptions($token, $channel, $limit = 25, $offset = 0, $direction = 'DESC')
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
            'direction' => $direction,
            'limit' => $limit,
            'offset' => $offset
        ));

        $channels = new Methods\Subscription;

        $channels->getSubscriptions($channel, $queryString);
    }

    /**
     * List the live streams that the authenticated user is following
     *  - requires scope 'user_read'
     * @param string
     * @param integer $limit
     * @param integer $offset
     * @param bool $hls
     * @return \stdClass
     * @throws TwitchException
     */
    public function authStreamsFollowed($token, $limit = 25, $offset = 0, $hls = null)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $queryString = $this->helper->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
            'limit' => $limit,
            'offset' => $offset,
            'hls' => $hls,
        ));

        $user = new Methods\User($this->request);
        return $user->getFollowedStreams($queryString);
    }

    /**
     * Get streams helper
     * @param null $game
     * @param null $limit
     * @param null $offset
     * @param null $channels
     * @param null $embeddable
     * @param null $hls
     * @return \stdClass
     * @throws TwitchException
     */
    public function getStreams($game = null, $limit = null, $offset = null, $channels = null, $embeddable = null, $hls = null)
    {
        $params = array(
            'game' => $game,
            'limit' => $limit,
            'offset' => $offset,
            'channel' => !empty($channels) ? $channels : null,
            'embeddable' => $embeddable,
            'hls' => $hls,
        );

        $queryString = $this->helper->buildQueryString($params);

        return $this->request->request(self::URI_STREAM . $queryString);
    }

    /**
     * Validate parameters for authentication
     * @param array
     * @return boolean
     */
    private function configValidate($config)
    {
        $check = array('client_id', 'client_secret', 'redirect_uri');

        foreach ($check AS $val) {
            if (!array_key_exists($val, $config) ||
                (empty($config[$val]) ||
                    !is_string($config[$val]))
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Configuration exception
     * @throws TwitchException
     */
    private function authConfigException()
    {
        throw new TwitchException('Cannot call authenticate functions without valid API configuration');
    }
}
