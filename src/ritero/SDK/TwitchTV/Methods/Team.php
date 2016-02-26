<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchRequest;
use ritero\SDK\TwitchTV\TwitchException;

/**
 * TwitchTV API SDK for PHP
 *
 * Teams method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
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
     * @throws TwitchException
     */
    public function getTeam($team)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_TEAM . $team);
    }

    /**
     * Returns a list of active teams
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/teams.md#get-teams
     * @param $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getTeams($queryString)
    {
        $this->request->setApiVersion(3);

        return $this->request->request(self::URI_TEAMS . $queryString);
    }
}
