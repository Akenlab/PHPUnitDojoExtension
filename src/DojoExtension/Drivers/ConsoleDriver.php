<?php

namespace Akenlab\DojoExtension\Drivers;

use Akenlab\DojoExtension\DojoAgentDriver;
use Akenlab\DojoExtension\DojoEvent;

class ConsoleDriver implements DojoAgentDriver
{
    public function dispatch(DojoEvent $event): void
    {
        var_dump($event->__serialize());
    }

}