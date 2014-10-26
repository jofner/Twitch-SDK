<?php

namespace ritero\SDK\TwitchTV\TwitchSDK\Test;

use \ritero\SDK\TwitchTV\TwitchSDK;

class TwitchSDKTest extends \PHPUnit_Framework_TestCase
{
    public function testSdk()
    {
        $sdk = new TwitchSDK;

        $this->assertEquals(new TwitchSDK, $sdk);
    }
}
