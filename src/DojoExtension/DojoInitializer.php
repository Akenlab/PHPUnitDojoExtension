<?php

namespace Akenlab\DojoExtension;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class DojoInitializer
{
    public static function postInstall(Event $event)
    {
        var_dump("-------------");
        var_dump("-------------");
        var_dump("POST INSTALL");
        var_dump($event->getName());
        var_dump("-------------");
    }
}
