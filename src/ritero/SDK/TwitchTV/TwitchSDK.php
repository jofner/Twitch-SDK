<?php

namespace ritero\SDK\TwitchTV;

/**
 * TwitchTV API SDK for PHP
 * 
 * PHP SDK for interacting with the TwitchTV API
 * 
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @version 0.1
 */
class TwitchSDK
{
    /** @var array */
    protected $authConfig = false;

    /**
     * TwitchAPI URI's
     */
    const URL_TWITCH = 'https://api.twitch.tv/kraken/';
    const URI_USER = 'users/';
    const URI_CHANNEL = 'channels/';
    const URI_STREAM = 'streams/';
    const URI_STREAM_SUMMARY = 'streams/summary/';
    const URI_STREAMS_FEATURED = 'streams/featured/';
    const URI_STREAMS_SEARCH = 'search/streams/';
    const URI_VIDEO = 'videos/';
    const URI_CHAT = 'chat/';
    const URI_CHAT_EMOTICONS = 'chat/%s/emoticons';
    const URI_GAMES_TOP = 'games/top/';
    const URI_AUTH = 'oauth2/authorize';
    const URI_AUTH_TOKEN = 'oauth2/token';
    const URI_USER_AUTH = 'user';
    const URI_CHANNEL_AUTH = 'channel';
    const URI_STREAMS_FOLLOWED_AUTH = 'streams/followed';

    /**
     * SDK constructor
     * @param   array
     * @throws  \ritero\SDK\TwitchTV\TwitchException
     */
    public function __construct($config = array())
    {
        if (!in_array('curl', get_loaded_extensions())) {
            throw new TwitchException('cURL extension is not installed and is required');
        }

        if (!empty($config)) {
            if ($this->configValidate($config) === true) {
                $this->authConfig = $config;
            } else {
                throw new TwitchException('Wrong Twitch API config parameters');
            }
        }
    }

    /**
     * Get the specified user
     * @param   string
     * @return  stdClass
     */
    public function userGet($username)
    {
        return $this->request(self::URI_USER . $username);
    }

    /**
     * Get the specified channel
     * @param   string
     * @return  stdClass
     */
    public function channelGet($channel)
    {
        return $this->request(self::URI_CHANNEL . $channel);
    }

    /**
     * Get the specified channel's stream
     * @param   string
     * @return  stdClass
     */
    public function streamGet($channel)
    {
        return $this->request(self::URI_STREAM . $channel);
    }

    /**
     * Search live streams
     * @param   string
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function streamSearch($query, $limit = null, $offset = null)
    {
        $query_string = $this->buildQueryString(array(
            'query' => $query,
            'limit' => $limit,
            'offset' => $offset,
            ));

        return $this->request(self::URI_STREAMS_SEARCH . $query_string);
    }

    /**
     * Summarize streams
     * @param   string
     * @param   array
     * @return  stdClass
     */
    public function streamsSummarize($game = null, array $channels = null)
    {
        if (!empty($channels)) {
            $channels = implode(',', $channels);
        }

        $query_string = $this->buildQueryString(array(
            'game' => $game,
            'channel' => $channels,
            ));

        return $this->request(self::URI_STREAM_SUMMARY . $query_string);
    }

    /**
     * Get featured streams
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function streamsFeatured($limit = null, $offset = null)
    {
        $query_string = $this->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
            ));

        return $this->request(self::URI_STREAMS_FEATURED . $query_string);
    }

    /**
     * Get streams by channel
     * @param   array
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function streamsByChannels($channels, $limit = null, $offset = null)
    {
        $channels_string = implode(',', $channels);

        return $this->getStreams(null, $limit, $offset, $channels_string);
    }

    /**
     * Get streams by game
     * @param   string
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function streamsByGame($game, $limit = null, $offset = null)
    {
        return $this->getStreams($game, $limit, $offset);
    }

    /**
     * Get video
     * @param   integer
     * @return  stdClass
     */
    public function videoGet($video)
    {
        return $this->request(self::URI_VIDEO . $video);
    }

    /**
     * Get videos for a channel
     * @param   string
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function videosByChannel($channel, $limit = null, $offset = null)
    {
        $query_string = $this->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
            ));

        return $this->request(self::URI_CHANNEL . $channel . '/' . self::URI_VIDEO . $query_string);
    }

    /**
     * Get the specified channel's chat
     * @param   string
     * @return  stdClass
     */
    public function chatGet($channel)
    {
        return $this->request(self::URI_CHAT . $channel);
    }

    /**
     * Get a chat's emoticons
     * @param   string
     * @return  stdClass
     */
    public function chatEmoticons($channel)
    {
        return $this->request(sprintf(self::URI_CHAT_EMOTICONS, $channel));
    }

    /**
     * Get top games
     * @param   integer
     * @param   integer
     * @return  stdClass
     */
    public function gamesTop($limit = null, $offset = null)
    {
        $query_string = $this->buildQueryString(array(
            'limit' => $limit,
            'offset' => $offset,
            ));

        return $this->request(self::URI_GAMES_TOP . $query_string);
    }

    /**
     * Get login URL for authentication
     * @param   string
     * @return  string
     */
    public function authLoginURL($scope)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $query_string = $this->buildQueryString(array(
            'response_type' => 'code',
            'client_id' => $this->authConfig['client_id'],
            'redirect_uri' => $this->authConfig['redirect_uri'],
            'scope' => $scope,
            ));

        return self::URL_TWITCH . self::URI_AUTH . $query_string;
    }

    /**
     * Get authentication access token
     * @param   string code returned after app authorization by user
     * @return  stdClass
     */
    public function authAccessTokenGet($code)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $query_string = $this->buildQueryString(array(
            'client_id' => $this->authConfig['client_id'],
            'client_secret' => $this->authConfig['client_secret'],
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->authConfig['redirect_uri'],
            'code' => $code,
            ));

        return $this->request(self::URI_AUTH_TOKEN . $query_string, 'POST');
    }

    /**
     * Get the authenticated user
     *  - requires scope 'user_read'
     * @param   string
     * @return  stdClass
     */
    public function authUserGet($token)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $query_string = $this->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
            ));

        return $this->request(self::URI_USER_AUTH . $query_string);
    }

    /**
     * Get the authenticated channel
     *  - requires scope 'channel_read'
     * @param   string
     * @return  stdClass
     */
    public function authChannelGet($token)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $query_string = $this->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
            ));

        return $this->request(self::URI_CHANNEL_AUTH . $query_string);
    }

    /**
     * List the live streams that the authenticated user is following
     *  - requires scope 'user_read'
     * @param   string
     * @return  stdClass
     */
    public function authStreamsFollowed($token)
    {
        if ($this->authConfig === false) {
            $this->authConfigException();
        }

        $query_string = $this->buildQueryString(array(
            'oauth_token' => $token,
            'client_id' => $this->authConfig['client_id'],
            ));

        return $this->request(self::URI_STREAMS_FOLLOWED_AUTH . $query_string);
    }

    /**
     * Get streams helper
     * @param   string
     * @param   integer
     * @param   integer
     * @param   string
     * @return  stdClass
     */
    private function getStreams($game = null, $limit = null, $offset = null, $channels = null)
    {
        $params = array(
            'game' => $game,
            'limit' => $limit,
            'offset' => $offset,
            'channel' => !empty($channels) ? $channels : null,
        );

        $query_string = $this->buildQueryString($params);

        return $this->request(self::URI_STREAM . $query_string);
    }

    /**
     * Validate parameters for authentication
     * @param   array
     * @return  boolean
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
     * Build query string
     * @param   array
     * @return  string
     */
    private function buildQueryString($params)
    {
        $param = array();
        $query_string = null;

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $param[$key] = $value;
            }
        }

        if (!empty($param)) {
            $query_string = '?' . http_build_query($param);
        }

        return $query_string;
    }

    /**
     * TwitchAPI request
     * @param   string
     * @param   string
     * @param   array
     * @return  stdClass
     * @throws  \ritero\SDK\TwitchTV\TwitchException
     */
    private function request($uri, $type = 'GET', $fields = array())
    {
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, self::URL_TWITCH . $uri);
        curl_setopt($crl, CURLOPT_HEADER, 0);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($crl, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
        curl_setopt($crl, CURLOPT_CUSTOMREQUEST, $type);

        if (!empty($fields)) {
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . urlencode($value) . '&';
            }
            rtrim($fields_string, '&');

            curl_setopt($crl, CURLOPT_POST, count($fields));
            curl_setopt($crl, CURLOPT_POSTFIELDS, $fields_string);
        }

        $ret = curl_exec($crl);

        if (curl_errno($crl)) {
            throw new TwitchException(curl_error($crl), curl_errno($crl));
        }

        curl_close($crl);

        return json_decode($ret);
    }

    /**
     * Configuration exception
     * @throws  \ritero\SDK\TwitchTV\TwitchException
     */
    private function authConfigException()
    {
        throw new TwitchException('Cannot call authenticate functions without valid API configuration');
    }
}
