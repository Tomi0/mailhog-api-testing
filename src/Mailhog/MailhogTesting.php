<?php

namespace Mailhog;

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

        $result = file_get_contents($this->getBaseUrl() . '/v2/search?' . $this->getSerializedUrlParameters($queryParams));

        echo $result;

        var_dump($result);

        return false;
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
            $result .= $key . '=' . $value . (++$i !== $numParameters ? '&' : '');
        }

        return urlencode($result);
    }
}