<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchRequest;
use jofner\SDK\TwitchTV\TwitchSDKException;

/**
 * Teams method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Team
{
    /** @var TwitchRequest */
    protected $request;

    const URI_TEAM = 'teams/';
    const URI_TEAMS = 'teams';

    /**
     * Team constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the specified team
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/teams.md#get-teamsteam
     * @param string $team
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getTeam($team)
    {
        return $this->request->request(self::URI_TEAM . $team);
    }

    /**
     * Returns a list of active teams
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/teams.md#get-teams
     * @param $queryString
     * @return \stdClass
     * @throws TwitchSDKException
     */
    public function getTeams($queryString)
    {
        return $this->request->request(self::URI_TEAMS . $queryString);
    }
}
