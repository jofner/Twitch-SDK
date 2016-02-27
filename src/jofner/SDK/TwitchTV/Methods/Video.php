<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchRequest;
use jofner\SDK\TwitchTV\TwitchException;

/**
 * Videos method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Video
{
    /** @var TwitchRequest */
    protected $request;

    const URI_VIDEO = 'videos/';
    const URI_VIDEO_TOP = 'videos/top';
    const URI_VIDEO_CHANNEL = 'channels/%s/videos';

    /**
     * Video constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a video object
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-videosid
     * @param string $id
     * @return \stdClass
     * @throws TwitchException
     */
    public function getVideo($id)
    {
        return $this->request->request(self::URI_VIDEO . $id);
    }

    /**
     * Returns a list of videos created in a given time period sorted by number of views, most popular first
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-videostop
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getTop($queryString)
    {
        return $this->request->request(self::URI_VIDEO_TOP . $queryString);
    }

    /**
     * Returns a list of videos ordered by time of creation, starting with the most recent from :channel
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md#get-channelschannelvideos
     * @param string $channel
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getChannelVideos($channel, $queryString)
    {
        return $this->request->request(sprintf(self::URI_VIDEO_CHANNEL, $channel) . $queryString);
    }
}
