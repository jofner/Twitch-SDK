<?php

namespace jofner\SDK\TwitchTV;

/**
 * TwitchRequest for TwitchTV API SDK for PHP
 *
 * PHP SDK for interacting with the TwitchTV API
 *
 * @author Josef Ohnheiser <jofnercz@gmail.com>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class TwitchRequest
{
    /** @var string Set the useragnet */
    private $userAgent = 'jofner TwitchSDK 2.*';

    /** @var integer Set connect timeout */
    public $connectTimeout = 30;

    /** @var integer Set timeout default. */
    public $timeout = 30;

    /** @var boolean Verify SSL Cert */
    public $sslVerifypeer = false;

    /** @var integer Contains the last HTTP status code returned */
    public $httpCode = 0;

    /** @var array Contains the last HTTP headers returned */
    public $httpInfo = array();

    /** @var array Contains the last Server headers returned */
    public $httpHeader = array();

    /** @var boolean Throw cURL errors */
    public $throwCurlErrors = true;

    /** @var int API version to use */
    private $apiVersion = 3;

    /** @var string */
    private $clientId;

    const URL_TWITCH = 'https://api.twitch.tv/kraken/';
    const URL_TWITCH_TEAM = 'http://api.twitch.tv/api/team/';
    const URI_AUTH = 'oauth2/authorize';
    const URI_AUTH_TOKEN = 'oauth2/token';
    const MIME_TYPE = 'application/vnd.twitchtv.v%d+json';

    /**
     * Set the API version to use
     * @param integer $version
     * @deprecated will be removed, force to use v3 API, which is current stable Twitch API version
     */
    public function setApiVersion($version)
    {
        if (ctype_digit(strval($version))) {
            $this->apiVersion = (int)$version;
        }
    }

    /**
     * Get the API version
     * @return int
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Get Client ID
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set CLient ID
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * TwitchAPI request
     * @param   string
     * @param   string
     * @param   string
     * @return  \stdClass
     * @throws  \jofner\SDK\TwitchTV\TwitchSDKException
     */
    public function request($uri, $method = 'GET', $postfields = null)
    {
        return $this->generalRequest(self::URL_TWITCH . $uri, $method, $postfields);
    }

    /**
     * Twitch Team API request
     * @param   string
     * @param   string
     * @param   string
     * @return  \stdClass
     * @throws  \jofner\SDK\TwitchTV\TwitchSDKException
     */
    public function teamRequest($uri, $method = 'GET', $postfields = null)
    {
        return $this->generalRequest(self::URL_TWITCH_TEAM . $uri . '.json', $method, $postfields);
    }

    /**
     * TwitchAPI request
     * method used by teamRequest && request methods
     * because there are two different Twitch APIs
     * don't call it directly
     * @param   array
     * @param   string
     * @param   string
     * @param   string
     * @return  \stdClass
     * @throws  \jofner\SDK\TwitchTV\TwitchSDKException
     */
    private function generalRequest($uri, $method = 'GET', $postfields = null)
    {
        $this->httpInfo = array();
        $optHttpHeader = array(
            'Expect:',
            'Accept: ' . sprintf(self::MIME_TYPE, $this->getApiVersion()),
            'Client-ID: ' . $this->getClientId(),
        );

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($crl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($crl, CURLOPT_HEADER, false);

        switch ($method) {
            case 'POST':
                curl_setopt($crl, CURLOPT_POST, true);
                break;
            case 'PUT':
                curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'DELETE':
                curl_setopt($crl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        if ($postfields !== null) {
            curl_setopt($crl, CURLOPT_POSTFIELDS, ltrim($postfields, '?'));
            $optHttpHeader[] = 'Content-Length: ' . strlen($postfields);
        }

        curl_setopt($crl, CURLOPT_HTTPHEADER, $optHttpHeader);

        curl_setopt($crl, CURLOPT_URL, $uri);

        $response = curl_exec($crl);

        $this->httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);
        $this->httpInfo = array_merge($this->httpInfo, curl_getinfo($crl));

        if (curl_errno($crl) && $this->throwCurlErrors === true) {
            throw new TwitchSDKException(curl_error($crl), curl_errno($crl));
        }

        curl_close($crl);

        return json_decode($response);
    }

    /**
     * Get the header info to store
     */
    private function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->httpHeader[$key] = $value;
        }

        return strlen($header);
    }
}
