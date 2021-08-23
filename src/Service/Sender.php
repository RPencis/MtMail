<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMail\Service;

use MtMail\Event\SenderEvent;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\TransportInterface;

class Sender implements EventManagerAwareInterface
{

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * Class constructor
     *
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->eventManager = new EventManager();
        }

        return $this->eventManager;
    }

    /**
     * Create and return event used by compose and send methods
     *
     * @return SenderEvent
     */
    protected function getEvent()
    {
        $event = new SenderEvent();
        $event->setTarget($this);

        return $event;
    }

    /**
     * Send message
     *
     * @param  Message $message
     * @return void
     */
    public function send(Message $message)
    {
        $em = $this->getEventManager();
        $event = $this->getEvent();
        $event->setMessage($message);
        $event->setName(SenderEvent::EVENT_SEND_PRE);
        $em->triggerEvent($event);
        $this->transport->send($message);
        $event->setName(SenderEvent::EVENT_SEND_POST);
        $em->triggerEvent($event);
    }
}
