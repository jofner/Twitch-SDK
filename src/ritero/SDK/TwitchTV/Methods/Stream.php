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
    const URI_STREAMS = 'streams';
    const URI_STREAMS_FEATURED = 'streams/featured';
    const URI_STREAM_SUMMARY = 'streams/summary';

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
     * @param string $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function getStream($channel)
    {
        return $this->request->request(self::URI_STREAM . $channel);
    }

    /**
     * Returns a list of streams
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streams
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getStreams($queryString)
    {
        return $this->request->request(self::URI_STREAMS . $queryString);
    }

    /**
     * Returns a list of featured (promoted) stream
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamsfeatured
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getFeatured($queryString)
    {
        return $this->request->request(self::URI_STREAMS_FEATURED . $queryString);
    }

    /**
     * Returns a summary of current streams
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md#get-streamssummary
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getSummary($queryString)
    {
        return $this->request->request(self::URI_STREAM_SUMMARY . $queryString);
    }
}
