<?php

namespace Mailhog;

class EmailMessage
{
    private string $from;
    private array $to;
    private string $subject;
    private string $body;
    private array $attachment;

    public function __construct(string $from, array $to, string $subject, string $body, array $attachment)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachment = $attachment;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getAttachment(): array
    {
        return $this->attachment;
    }
}