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
use MtMail\Template\HeadersProviderInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mail\Header\HeaderInterface;
use Laminas\Mail\Message;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\EventManager\ListenerAggregateInterface;

class DefaultHeaders implements ListenerAggregateInterface
{

    use ListenerAggregateTrait;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param ComposerEvent $event
     */
    public function injectDefaultHeaders(ComposerEvent $event)
    {
        $message = $event->getMessage();
        $this->addHeaders($message, $this->headers);

        if ($event->getTemplate() instanceof HeadersProviderInterface) {
            $this->addHeaders($message, $event->getTemplate()->getHeaders());
        }
    }

    /**
     * @param Message $message
     * @param HeaderInterface[]|string[] $headers
     */
    private function addHeaders(Message $message, $headers)
    {
        foreach ($headers as $header => $value) {
            if ($value instanceof HeaderInterface) {
                $message->getHeaders()->addHeader($value);
            } else {
                $message->getHeaders()->addHeaderLine($header, $value);
            }
        }
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
        $this->listeners[] = $events->attach(ComposerEvent::EVENT_HEADERS_PRE, [$this, 'injectDefaultHeaders']);
    }

    /**
     * @param  array $headers
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
