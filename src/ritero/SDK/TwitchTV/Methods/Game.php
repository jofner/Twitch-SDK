<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;
use ritero\SDK\TwitchTV\TwitchException;

/**
 * TwitchTV API SDK for PHP
 *
 * Games method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
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
