E-mail module for Zend Framework
================================

[![Build Status](https://travis-ci.org/mtymek/MtMail.png?branch=master)](https://travis-ci.org/mtymek/MtMail)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mtymek/MtMail/badges/quality-score.png?s=f03d22161755c845d0ce06ab90a67cf4e3e340e0)](https://scrutinizer-ci.com/g/mtymek/MtMail/)
[![Code Coverage](https://scrutinizer-ci.com/g/mtymek/MtMail/badges/coverage.png?s=d4b2ac636d43b3dd8042675dd32ac8fe2cf4e390)](https://scrutinizer-ci.com/g/mtymek/MtMail/)
[![Latest Stable Version](https://poser.pugx.org/mtymek/mt-mail/v/stable.png)](https://packagist.org/packages/mtymek/mt-mail)
[![Total Downloads](https://poser.pugx.org/mtymek/mt-mail/downloads.png)](https://packagist.org/packages/mtymek/mt-mail)

Introduction
------------
MtMail handles common activities surrounding sending e-mail from applications, mainly creating messages
from templates, and sending them through transport adapters.

### Features:
* factory for creating e-mail messages
* factory for e-mail transport adapters, service for one-line dispatch
* rendering templates from `phtml` files, using `Laminas\View` and `PhpRenderer`
* rendering templates with layouts
* plugins for various common tasks: from setting default headers to generating plaintext version of HTML message
* plugin support via dedicated plugin managers

Installation
------------
Installation is supported via Composer:

```bash
$ composer require mtymek/mt-mail
```


Creating e-mails
----------------

### Configuration

By default MtMail doesn't require any extra configuration. It will use `Laminas\View` to render
templates accessible by your application.

### Usage

Creating message from controller:

```php
$mailService = $this->getServiceLocator()->get(\MtMail\Service\Mail::class);

$headers = [
    'to' => 'johndoe@domain.com',
    'from' => 'contact@mywebsite.com',
];
$variables = [
    'userName' => 'John Doe',
];
$message = $mailService->compose($headers, 'application/mail/welcome.phtml', $variables);
```

This snippet will create a message, compose it with `$headers` and HTML body
rendered from `welcome.phtml` template (injected with `$variables` array).


### Layouts

In order to give your e-mails common layout, you have to enable "Layout" plugin and tell it where
to look for layout template:

```php
return [
    'mt_mail' => [
        'composer_plugins' => [
            'Layout',
        ],
        'layout' => 'application/mail/layout.phtml',
    ],
];
```

For more info about composing e-mail messages, check [the documentation](doc/Composing messages.md).
You can also check [documentation for plugins](doc/Composer Plugins.md).

Sending e-mails
---------------

### Configuration

Update your application config:

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
### Usage
---------

Add following code to your controller:

```php
// create and configure message
$message = new Message();
$message->addTo('johndoe@domain.com');
// ...

// send!
$mailService = $this->getServiceLocator()->get(\MtMail\Service\Mail::class);
$mailService->send($message);
```

For more info on sending e-mails, check [the documentation](doc/Sending messages.md).
