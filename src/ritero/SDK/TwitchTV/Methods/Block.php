<?php

namespace ritero\SDK\TwitchTV\Methods;

use ritero\SDK\TwitchTV\TwitchException;
use ritero\SDK\TwitchTV\TwitchRequest;

/**
 * TwitchTV API SDK for PHP
 *
 * Block method class
 *
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Block
{
    /** @var TwitchRequest */
    protected $request;

    const URI_BLOCK_USER = 'users/%s/blocks';

    /**
     * Block constructor
     * @param TwitchRequest $request
     */
    public function __construct(TwitchRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a list of blocks
     *  - required scope 'user_blocks_read'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#get-usersuserblocks
     * @param string $user
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function getBlocks($user, $queryString)
    {
        return $this->request->request(sprintf(self::URI_BLOCK_USER, $user) . $queryString);
    }
}
