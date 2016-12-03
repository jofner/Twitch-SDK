<?php

namespace jofner\SDK\TwitchTV\TwitchSDK\Methods\Test;

use jofner\SDK\TwitchTV\TwitchSDK;

class AuthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException jofner\SDK\TwitchTV\TwitchSDKException
     */
    public function testAuthLoginURLException()
    {
        $sdk = new TwitchSDK(array());
        $sdk->authLoginURL('test_scope');
    }
}
