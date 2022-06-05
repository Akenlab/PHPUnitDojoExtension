<?php

namespace Akenlab;

use Akenlab\DojoExtension\DojoAgent;
use Akenlab\DojoExtension\DojoAgentDriver;
use Akenlab\DojoExtension\DojoEvent;
use Akenlab\DojoExtension\DojoListener;
use Akenlab\DojoExtension\Events\TestsWereRun;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;

class DojoExtensionTest extends TestCase
{
    public function test_extension_calls_dojo_agent_on_each_test_suite_run()
    {
        $teamId = "MyTeamId";
        $dojoAgent = $this->createMock(DojoAgent::class);
        $dojoAgent->method("teamId")->willReturn($teamId);

        $dojoAgent->expects($this->once())->method("dispatch")->with($this->callback(function(TestsWereRun $event) use ($teamId){
            $this->assertEquals($teamId,$event->teamId());
            return true;
        }));
        $extension = new DojoListener($dojoAgent);
        $suite = $this->createMock(TestSuite::class);
        $extension->endTestSuite($suite);
    }

    public function test_agent_requires_a_driver()
    {
        $driver = $this->createMock(DojoAgentDriver::class);
        $driver->expects($this->once())->method("dispatch");
        $dojoAgent=new DojoAgent($driver);
        $dojoAgent->dispatch(new DojoEvent());

    }
}
