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
}
