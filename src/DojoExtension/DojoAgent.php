<?php

namespace Akenlab\DojoExtension;

class DojoAgent
{

    private DojoAgentDriver $driver;

    public function __construct(DojoAgentDriver $driver)
    {
        $this->driver = $driver;
    }

    public function dispatch(DojoEvent $event)
    {
        $this->driver->dispatch($event);
    }

    public function teamId()
    {
        return $this->teamId();
    }
}