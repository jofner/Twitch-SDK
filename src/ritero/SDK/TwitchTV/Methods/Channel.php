<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchException;
use ritero\SDK\TwitchTV\TwitchRequest;

/**
 * TwitchTV API SDK for PHP
 *
 * Channels method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Channel
{
    /** @var TwitchRequest */
    protected $request;

    const URI_CHANNEL_AUTH = 'channel';
    const URI_CHANNELS = 'channels/';
    const URI_CHANNEL_KEY = 'channels/%s/stream_key';
    const URI_CHANNEL_EDITORS_AUTH = 'channels/%s/editors';
    const URI_CHANNEL_TEAMS = 'channels/%s/teams';

    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Update channel's status or game
     *  - requires scope 'channel_editor'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#put-channelschannel
     * @param string $channel
     * @param string $queryString
     * @param string $data
     * @return \stdClass
     * @throws TwitchException
     */
    public function setChannel($channel, $queryString, $data)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_CHANNELS . $channel . $queryString, 'PUT', $data);
    }

    /**
     * Get the authenticated channel
     *  - requires scope 'channel_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getChannel($queryString)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_CHANNEL_AUTH . $queryString);
    }

    /**
     * Resets channel's stream key
     *  - requires scope 'channel_stream'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#delete-channelschannelstream_key
     * @param $channel
     * @param $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function resetStreamKey($channel, $queryString)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(sprintf(self::URI_CHANNEL_KEY, $channel) . $queryString, 'DELETE');
    }

    /**
     * Get the specified channel
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschannel
     * @param string $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function getChannels($channel)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_CHANNELS . $channel);
    }

    /**
     * Returns an array of users who are editors of specified channel
     *  - requires scope 'channel_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschanneleditors
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getEditors($channel, $queryString)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(sprintf(self::URI_CHANNEL_EDITORS_AUTH, $channel) . $queryString);
    }

    /**
     * Return team list for specified channel
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#get-channelschannelteams
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function getTeams($channel)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(sprintf(self::URI_CHANNEL_TEAMS, $channel));
    }
}
