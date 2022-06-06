<?php

namespace Akenlab;

use Akenlab\DojoExtension\DojoAgent;
use Akenlab\DojoExtension\DojoAgentDriver;
use Akenlab\DojoExtension\DojoEvent;
use Akenlab\DojoExtension\DojoExtension;
use Akenlab\DojoExtension\Events\TestsWereRun;
use PHPUnit\Framework\TestCase;

class DojoExtensionTest extends TestCase
{
    public function test_extension_calls_dojo_agent_on_each_test_suite_run()
    {
        $teamId = "MyTeamId";
        $dojoAgentDriver = $this->createMock(DojoAgentDriver::class);

        $dojoAgentDriver->expects($this->once())->method("dispatch")->with($this->callback(function(TestsWereRun $event) use ($teamId){
            $this->assertEquals($teamId,$event->teamId());
            return true;
        }));
        $extension = new DojoExtension($dojoAgentDriver,$teamId);
        $extension->executeBeforeFirstTest();
    }

    public function test_agent_requires_a_driver()
    {
        $driver = $this->createMock(DojoAgentDriver::class);
        $driver->expects($this->once())->method("dispatch");
        $dojoAgent=DojoAgent::instance($driver,"TEAM2");
        $dojoAgent->dispatch($this->createMock(DojoEvent::class));
    }

    public function test_there_is_only_one_instance_of_agent_per_run()
    {
        $agent=DojoAgent::instance($this->createMock(DojoAgentDriver::class),"TEAM");
        $agent2=DojoAgent::instance($this->createMock(DojoAgentDriver::class),"TEAM");
        $this->assertSame($agent,$agent2);

    }

    public function test_agent_counts_failures_and_errors()
    {
        $driver = $this->createMock(DojoAgentDriver::class);
        $extension=new DojoExtension($driver,"TEAM");
        $agent=DojoAgent::instance($driver,"TEAM");
        $this->assertEquals(0,$agent->failuresCount());
        $extension->executeAfterTestError("test1","error",1);
        $this->assertEquals(1,$agent->failuresCount());
        $extension->executeAfterTestFailure("test2","failure",1);
        $this->assertEquals(2,$agent->failuresCount());

    }

    public function test_agent_counts_successful_tests()
    {
        $driver = $this->createMock(DojoAgentDriver::class);
        $extension=new DojoExtension($driver,"TEAM");
        $agent=DojoAgent::instance($driver,"TEAM");
        $this->assertEquals(0,$agent->successCount());
        $extension->executeAfterSuccessfulTest("test1",1);
        $this->assertEquals(1,$agent->successCount());

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        DojoAgent::destroy();
    }
}
