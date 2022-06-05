<?php

namespace Akenlab\DojoExtension\Events;

use Akenlab\DojoExtension\DojoEvent;

class TestsWereRun extends DojoEvent
{
    private string $teamId;

    public function __construct(string $teamId)
    {
        $this->teamId = $teamId;
    }

    public function teamId()
    {
        return $this->teamId;
    }
}