<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;
use ritero\SDK\TwitchTV\TwitchException;

/**
 * TwitchTV API SDK for PHP
 *
 * Chat method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Chat
{
    /** @var TwitchRequest */
    protected $request;

    const URI_CHAT = 'chat/';
    const URI_CHAT_EMOTICONS = 'chat/emoticons';

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
     * @param $channel
     * @return \stdClass
     * @throws TwitchException
     */
    public function getChat($channel)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_CHAT . $channel);
    }

    /**
     * Get a chat's emoticons
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md#get-chatemoticons
     * @return \stdClass
     * @throws TwitchException
     */
    public function getEmoticons()
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_CHAT_EMOTICONS);
    }
}
