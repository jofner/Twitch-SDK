<?php

namespace jofner\SDK\TwitchTV\Methods;

use jofner\SDK\TwitchTV\TwitchException;
use jofner\SDK\TwitchTV\TwitchRequest;

/**
 * Block method class for TwitchTV API SDK for PHP
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Block
{
    /** @var TwitchRequest */
    protected $request;

    const URI_BLOCK_USER = 'users/%s/blocks';
    const URI_BLOCK_TARGET = 'users/%s/blocks/%s';

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
     *  - requires scope 'user_blocks_read'
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

    /**
     * Adds $target to $user block list
     *  - requires scope 'user_blocks_edit'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#put-usersuserblockstarget
     * @param string $user
     * @param string $target
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function blockTarget($user, $target, $queryString)
    {
        return $this->request->request(sprintf(self::URI_BLOCK_TARGET, $user, $target) . $queryString, 'PUT');
    }

    /**
     * Removes $target from $user block list
     *  - requires scope 'user_blocks_edit'
     * @see https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#delete-usersuserblockstarget
     * @param string $user
     * @param string $target
     * @param string $queryString
     * @return \stdClass
     * @throws TwitchException
     */
    public function removeTarget($user, $target, $queryString)
    {
        return $this->request->request(sprintf(self::URI_BLOCK_TARGET, $user, $target) . $queryString, 'DELETE');
    }
}
