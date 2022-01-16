# Mailhog Api Testing

Test that your emails are sent

## Install
```composer
composer require tomi0/mailhog-api-testing
```

## Usage

Use Mailhog testing trait in your test:
```php
use Mailhog\MailhogTesting;

class ClassName {
    use MailhogTesting;
    ...
}
```

Set up environment:
```php
$this->setUpMailhogEnviroment($host, $smtpPort, $webPort, $isHttps);
```

Available methods:
```php
// Check if message exsits (return bool)
$this->messageExistsByContent($content);
$this->messageExists($content);

// Get all messages (return EmailMessage[])
$this->getAllMessages();

// Clear inbox (return bool)
$this->clearInbox();
$this->emptyInbox();
```
