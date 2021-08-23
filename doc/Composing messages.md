E-mail Composer
===============

Introduction
------------

If you just want to create simple e-mail message, you don't need to configure anything - MtMail will work out of
the box with basic settings, utilizing application's `View` for rendering templates. Here's minimal code required
to create a message:

```php
$mailService = $this->getServiceLocator()->get('MtMail\Service\Mail');

$headers = [
    'to' => 'johndoe@domain.com',
    'from' => 'contact@mywebsite.com',
];
$variables = [
    'userName' => 'John Doe',
];
$message = $mailService->compose($headers, 'application/mail/welcome.phtml', $variables);
/** @var \Laminas\Mail\Message $message */
```

`MtMail` also provides handy controller plugin that proxies to Mail service:

```php
$message = $this->mtMail()->compose($headers, 'application/mail/welcome.phtml', $variables);
```

Theory of operation
-------------------

Composing e-mail message is a process with following steps:

1. Create `Laminas\Mail\Message` object
2. Inject headers into message
3. Render HTML body
4. Render text body
5. Inject body into message

Each of this step can be controlled by [Composer Plugins](Composer Plugins.md).
