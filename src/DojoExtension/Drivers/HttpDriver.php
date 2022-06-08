<?php

namespace Akenlab\DojoExtension\Drivers;

use Akenlab\DojoExtension\DojoAgentDriver;
use Akenlab\DojoExtension\DojoEvent;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpDriver implements DojoAgentDriver
{
    private HttpClientInterface $httpClient;
    private string $eventStoreEndpoint;

    public function __construct(string $eventStoreEndpoint)
    {
        $this->httpClient=HttpClient::create();
        $this->eventStoreEndpoint = $eventStoreEndpoint;
    }

    public function dispatch(DojoEvent $event): void
    {
        $this->httpClient->request(
            "POST",
            $this->eventStoreEndpoint,
            [
                "json" => [
                    "payload" => $event->__serialize(),
                    "eventName"=>substr(strrchr(get_class($event), '\\'), 1)
                ]
            ]
        );
    }

}