<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchRequest;
use jofner\SDK\TwitchTV\TwitchException;

/**
 * Games method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Game
{
    /** @var TwitchRequest */
    protected $request;

    const URI_GAMES_TOP = 'games/top/';

    /**
     * Game constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get top games
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/games.md#get-gamestop
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getTop($queryString)
    {
        return $this->request->request(self::URI_GAMES_TOP . $queryString);
    }
}
