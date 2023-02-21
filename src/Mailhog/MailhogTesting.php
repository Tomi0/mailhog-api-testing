<?php

namespace Mailhog;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait MailhogTesting
{
    /**
     * @var string
     */
    protected $host;
    /**
     * @var int
     */
    protected $mailPort;
    /**
     * @var int
     */
    protected $apiPort;
    /**
     * @var bool
     */
    protected $ssl;

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

    /**
     * @throws GuzzleException
     */
    public function messageExistsByContent(string $content): bool
    {
        $queryParams = [
            'kind' => 'containing',
            'query' => $content,
        ];

        $client = new Client();

        $request = $client->request('GET', $this->getBaseUrl() . '/api/v2/search?' . $this->getSerializedUrlParameters($queryParams));

        $result = json_decode($request->getBody()->getContents(), true);

        return isset($result['count']) && $result['count'] > 0;
    }

    /**
     * @throws GuzzleException
     */
    public function messageExists(string $content): bool
    {
        return $this->messageExistsByContent($content);
    }

    /**
     * @return EmailMessage[]
     * @throws GuzzleException
     */
    public function getAllMessages(): array
    {
        $request = (new Client())->request('GET', $this->getBaseUrl() . '/api/v2/messages');

        $messages = [];
        foreach (json_decode($request->getBody()->getContents(), true)['items'] as $message) {
            $messages[] = $this->instanceEmailMessage($message);
        }

        return $messages;
    }

    /**
     * @throws GuzzleException
     */
    public function clearInbox(): bool
    {
        $request = (new Client())->request('DELETE', $this->getBaseUrl() . '/api/v1/messages');

        return $request->getStatusCode() === 200;
    }

    /**
     * @throws GuzzleException
     */
    public function emptyInbox(): bool
    {
        return $this->clearInbox();
    }

    private function getBaseUrl(): string
    {
        return ($this->ssl ? 'https://' : 'http://') . $this->host . ':' . $this->apiPort;
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

    private function instanceEmailMessage(array $message): EmailMessage
    {
        $from = $message['From']['Mailbox'] . '@' . $message['From']['Domain'];
        $to = array_map(function ($to) {
            return $to['Mailbox'] . '@' . $to['Domain'];
        }, $message['To']);

        return new EmailMessage(
            $from,
            $to,
            $message['Content']['Headers']['Subject'][0],
            $message['Content']['Body'],
            []
        );
    }
}