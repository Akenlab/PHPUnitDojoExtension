<?php

namespace Akenlab\DojoExtension;

use Akenlab\DojoExtension\Events\TestsWereRun;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

class DojoListener implements TestListener
{
    use TestListenerDefaultImplementation;

    private DojoAgent $dojoAgent;

    public function __construct(DojoAgent $dojoAgent)
    {
        $this->dojoAgent = $dojoAgent;
    }
    public function endTestSuite(TestSuite $suite): void
    {
        $event = new TestsWereRun($this->dojoAgent->teamId());
        $this->dojoAgent->dispatch($event);
    }
}