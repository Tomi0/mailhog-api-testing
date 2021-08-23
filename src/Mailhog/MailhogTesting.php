<?php

namespace Mailhog;

trait MailhogTesting
{
    protected string $host;
    protected int $port;

    /**
     * MailhogTesting constructor.
     * @param string $host
     * @param int $port
     */
    protected function setUpMailhogEnviroment(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function messageExistsByContent(string $content): bool
    {
        return false; // TODO
    }
}