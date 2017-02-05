<?php

namespace jofner\SDK\TwitchTV;

/**
 * Helper for TwitchTV API SDK for PHP
 *
 * PHP SDK for interacting with the TwitchTV API
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class Helper
{
    /**
     * Build query string
     * @param $params
     * @return null|string
     */
    public function buildQueryString($params)
    {
        $param = array();
        $queryString = null;

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $param[$key] = $value;
            }
        }

        if (count($param) > 0) {
            $queryString = '?' . http_build_query($param);
        }

        return $queryString;
    }
}
