Configuration
-------------

Before sending an e-mail, you need to tell MtMail which transport to use, and (optionally) configure it.
MtMail provides factories for Zend Framework's built-in transport classes, allowing you to pass options
using application configuration:

```php
return [
    'mt_mail' => [
        'transport' => \Laminas\Mail\Transport\Smtp::class,
        'transport_options' => [
            'host' => 'some-host.com',
            'connection_class' => 'login',
            'connection_config' => [
                'username' => 'user',
                'password' => 'pass',
                'ssl' => 'tls',
            ],
        ],
    ],
];
```

`transport` can be any service that is accessible from `ServiceManager` and implements `Laminas\Mail\Transport\TransportInterface`.
You can use this if you want to benefit from non-standard transports (for instance those from [SlmMail](https://github.com/juriansluiman/SlmMail) module).

Here's another example - configuring file transport:

```php
return [
    'mt_mail' => [
        'transport' => \Laminas\Mail\Transport\File::class,
        'transport_options' => [
            'path' => 'data/mail'
        ],
    ],
];
```

Sending messages
----------------

Once e-mail transport is configured, `MtMail\Service\Mail` becomes ready to be pulled from `ServiceManager`.
Usage (from controller):

```php
$sender = $this->getServiceLocator()->get(\MtMail\Service\Mail::class);
$sender->send($message);
```

where `$message` is an instance of `Laminas\Mail\Message`.

`MtMail` also provides handy controller plugin that proxies to Mail service:

```php
$this->mtMail()->send($message);
```
