<?php
/**
 * MtMail - e-mail module for Zend Framework
 *
 * @link      http://github.com/mtymek/MtMail
 * @copyright Copyright (c) 2013-2017 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtMail\ComposerPlugin;

use MtMail\Event\ComposerEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\EventManager\ListenerAggregateInterface;

class MessageEncoding implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var string
     */
    protected $encoding;

    /**
     * Set encoding of message inside event
     *
     * @param ComposerEvent $event
     */
    public function setMessageEncoding(ComposerEvent $event)
    {
        $event->getMessage()->setEncoding($this->encoding);
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ComposerEvent::EVENT_COMPOSE_PRE, [$this, 'setMessageEncoding']);
    }

    /**
     * @param  string $encoding
     * @return self
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }
}
