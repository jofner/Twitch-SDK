<?php

namespace ritero\SDK\TwitchTV\TwitchSDK\Methods\Test;

use ritero\SDK\TwitchTV\TwitchSDK;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException ritero\SDK\TwitchTV\TwitchException
     */
    public function testAuthLoginURLException()
    {
        $sdk = new TwitchSDK(array());
        $sdk->authLoginURL('test_scope');
    }
}
