<?php

namespace Mailhog;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait MailhogTesting
{
    protected string $host;
    protected int $mailPort;
    protected int $apiPort;
    protected bool $ssl;

    /**
     * MailhogTesting constructor.
     * @param string $host
     * @param int $mailPort
     * @param int $apiPort
     * @param bool $ssl
     */
    protected function setUpMailhogEnviroment(string $host, int $mailPort, int $apiPort, bool $ssl = false)
    {
        $this->host = $host;
        $this->mailPort = $mailPort;
        $this->apiPort = $apiPort;
        $this->ssl = $ssl;
    }

    public function messageExistsByContent(string $content): bool
    {
        $queryParams = [
            'kind' => 'containing',
            'query' => $content,
        ];

        $client = new Client();

        $result = $client->request('GET', $this->getBaseUrl() . '/v2/search?' . $this->getSerializedUrlParameters($queryParams));

        $result = json_decode($result->getBody()->getContents(), true);

        return isset($result['count']) && $result['count'] > 0;
    }

    public function clearInbox(): bool
    {
        return false; // TODO
    }

    private function getBaseUrl(): string
    {
        return ($this->ssl ? 'https://' : 'http://') . $this->host . ':' . $this->apiPort . '/api';
    }

    private function getSerializedUrlParameters(array $parameters = []): string
    {
        $result = '';
        $numParameters = count($parameters);
        $i = 0;

        foreach ($parameters as $key => $value) {
            $result .= $key . '=' . urlencode($value) . (++$i !== $numParameters ? '&' : '');
        }

        return $result;
    }
}