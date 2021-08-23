<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMail\Event;

use Laminas\EventManager\Event;
use Laminas\Mail\Message;

class SenderEvent extends Event
{
    /**#@+
     * Mail events
     */
    const EVENT_SEND_PRE = 'send.pre';
    const EVENT_SEND_POST = 'send.post';
    /**#@-*/

    /**
     * @var Message
     */
    protected $message;

    /**
     * @param  \Laminas\Mail\Message $message
     * @return self
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return \Laminas\Mail\Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
