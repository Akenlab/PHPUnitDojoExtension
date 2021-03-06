<?php

namespace Akenlab\DojoExtension;

use Akenlab\DojoExtension\Events\TestsWereRun;
use Akenlab\DojoExtension\Events\TestRunnerStarted;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterSuccessfulTestHook;
use PHPUnit\Runner\AfterTestErrorHook;
use PHPUnit\Runner\AfterTestFailureHook;
use PHPUnit\Runner\BeforeFirstTestHook;

final class DojoExtension implements BeforeFirstTestHook,AfterTestErrorHook,AfterTestFailureHook,AfterSuccessfulTestHook,AfterLastTestHook
{
    private DojoAgent $dojoAgent;

    public function __construct(DojoAgentDriver $driver,string $teamId,string $teamName)
    {
        $dojoAgent=DojoAgent::instance($driver,$teamId,$teamName);
        $this->dojoAgent = $dojoAgent;
    }
    public function executeBeforeFirstTest(): void
    {
        $event = new TestRunnerStarted($this->dojoAgent->teamId(),$this->dojoAgent->teamName());
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
    public function executeAfterLastTest(): void
    {
        $event = new TestsWereRun($this->dojoAgent->teamId(),$this->dojoAgent->teamName(),$this->dojoAgent->successCount(),$this->dojoAgent->failuresCount());
        $this->dojoAgent->dispatch($event);
    }
}
