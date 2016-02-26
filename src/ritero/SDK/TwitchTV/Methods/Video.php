<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;
use ritero\SDK\TwitchTV\TwitchException;

/**
 * TwitchTV API SDK for PHP
 *
 * Videos method class
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
}
