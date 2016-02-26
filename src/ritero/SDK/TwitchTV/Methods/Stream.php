<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;
use ritero\SDK\TwitchTV\TwitchException;

/**
 * TwitchTV API SDK for PHP
 *
 * Streams method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Stream
{
    /** @var TwitchRequest */
    protected $request;

    const URI_STREAM = 'streams/';

    /**
     * Stream constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the specified channel's stream
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamschannel
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function getStream($channel)
    {
        return $this->request->request(self::URI_STREAM . $channel);
    }
}
