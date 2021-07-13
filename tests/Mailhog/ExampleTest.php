<?php


namespace Tests\Mailhog;


use Mailhog\MailhogTesting;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use MailhogTesting;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testTrue(): void
    {
        $this->assertTrue(true);
    }
}