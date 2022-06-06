<?php

namespace Akenlab\DojoExtension;

use Akenlab\DojoExtension\Events\TestsWereRun;
use PHPUnit\Runner\AfterSuccessfulTestHook;
use PHPUnit\Runner\AfterTestErrorHook;
use PHPUnit\Runner\AfterTestFailureHook;
use PHPUnit\Runner\BeforeFirstTestHook;

final class DojoExtension implements BeforeFirstTestHook,AfterTestErrorHook,AfterTestFailureHook,AfterSuccessfulTestHook
{
    private DojoAgent $dojoAgent;

    public function __construct(DojoAgentDriver $driver,string $teamId)
    {
        $dojoAgent=DojoAgent::instance($driver,$teamId);
        $this->dojoAgent = $dojoAgent;
    }
    public function executeBeforeFirstTest(): void
    {
        $event = new TestsWereRun($this->dojoAgent->teamId(),$this->dojoAgent->successCount(),$this->dojoAgent->failuresCount());
        $this->dojoAgent->dispatch($event);
    }

    public function executeAfterTestError(string $test,string $message, float $time):void
    {
        $this->dojoAgent->addFailure();
    }

    public function executeAfterTestFailure(string $test, string $message, float $time):void
    {
        $this->dojoAgent->addFailure();
    }

    public function executeAfterSuccessfulTest(string $test, float $time):void
    {
        $this->dojoAgent->addSuccess();
    }
}