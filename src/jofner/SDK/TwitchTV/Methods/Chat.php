<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchRequest;
use jofner\SDK\TwitchTV\TwitchSDKException;

/**
 * Chat method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Chat
{
    /** @var TwitchRequest */
    protected $request;

    const URI_CHAT = 'chat/';
    const URI_CHAT_EMOTICONS = 'chat/emoticons';
    const URI_CHAT_EMOTICONS_IMAGES = 'chat/emoticon_images';
    const URI_CHAT_BADGES = 'chat/%s/badges';

    /**
     * Chat constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a links object to all other chat endpoints
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatchannel
     * @param string $channel
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getChat($channel)
    {
        return $this->request->request(self::URI_CHAT . $channel);
    }

    /**
     * Get a chat's emoticons
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatemoticons
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getEmoticons()
    {
        return $this->request->request(self::URI_CHAT_EMOTICONS);
    }

    /**
     * Returns a list of emoticons
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatemoticon_images
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getEmoticonImages($queryString)
    {
        return $this->request->request(self::URI_CHAT_EMOTICONS_IMAGES . $queryString);
    }

    /**
     * Returns a list of chat badges that can be used in the :channel's chat
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatchannelbadges
     * @param string $channel
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getBadges($channel)
    {
        return $this->request->request(sprintf(self::URI_CHAT_BADGES, $channel));
    }
}
