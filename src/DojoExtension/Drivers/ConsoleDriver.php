<?php

namespace Akenlab\DojoExtension\Drivers;

use Akenlab\DojoExtension\DojoAgentDriver;
use Akenlab\DojoExtension\DojoEvent;
use Akenlab\DojoExtension\Events\TestsWereRun;

class ConsoleDriver implements DojoAgentDriver
{
    public function dispatch(DojoEvent $event): void
    {
        if(get_class($event)===TestsWereRun::class){
            $width = 60;
            print str_pad("", $width,"-")."\n";
            print str_pad("-- This is a (pretty useless) example of a driver result ", $width,"-")."\n";
            print str_pad("-- Passing : ".$event->successCount()." ", $width,"-")."\n";
            print str_pad("-- Failing : ".$event->failuresCount()." ", $width,"-")."\n";
            print str_pad("", $width,"-")."\n";
        }
    }

}