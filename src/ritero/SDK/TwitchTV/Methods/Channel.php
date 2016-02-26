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
    const URI_CHANNEL_EDITORS_AUTH = 'channels/%s/editors';

    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
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
}
