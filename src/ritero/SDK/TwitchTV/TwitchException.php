<?php

namespace ritero\SDK\TwitchTV;

/**
 * TwitchException for TwitchTV API SDK for PHP
 * 
 * PHP SDK for interacting with the TwitchTV API
 * 
 * @author Josef Ohnheiser <ritero@ritero.eu>
 * @license https://github.com/jofner/Twitch-SDK/blob/master/LICENSE.md MIT
 * @homepage https://github.com/jofner/Twitch-SDK
 */
class TwitchException extends \Exception
{
    /** @var string */
    protected $message = 'Unknown exception';

    /** @var integer */
    protected $code;

    /** @var \ritero\SDK\TwitchTV\TwitchException */
    protected $previous;

    public function __construct($message = null, $code = 0, \ritero\SDK\TwitchTV\TwitchException $previous = null)
    {
        $this->code = $code;
        if (!is_null($message)) {
            $this->message = $message;
        }
        $this->previous = $previous;

        parent::__construct($this->message, $this->code, $this->previous);
    }

    /**
     * Formatted string for display
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . ': [' . $this->code . ']: ' . $this->message;
    }
}