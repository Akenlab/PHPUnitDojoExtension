<?php

namespace Akenlab\DojoExtension;

use Akenlab\DojoExtension\Drivers\HttpDriver;
use Composer\Script\Event;

class DojoInitializer
{
    public static function postInstall(Event $event)
    {
        $teamName= self::forgeTeamName();
        $teamId= uniqid();
        $phpUnit = simplexml_load_file("phpunit.xml.dist");
        $extensions=$phpUnit->xpath("/phpunit/extensions");
        if (!$extensions) {
            $extensions=$phpUnit->addChild("extensions");
        }else{
            $extensions=$extensions[0];
        }
        if($extensions->xpath("extension[@class='".DojoExtension::class."']")){
            $extension=$extensions->xpath("extension[@class='".DojoExtension::class."']")[0];
        }else{
            $extension=NULL;
        }
        if(!$extension){
            $extension=$extensions->addChild("extension");
            $extension->addAttribute("class",DojoExtension::class);
            $arguments = $extension->addChild("arguments");
            $object = $arguments->addChild("object");
            $object->addAttribute("class",HttpDriver::class);
            $arguments2 = $object->addChild("arguments");
            $arguments2->addChild("string","http://dojo-server.k8s.iut-larochelle.fr/api/teams");
            $arguments->addChild("string",$teamId);
            $arguments->addChild("string",$teamName);
        }else{
            $extension->xpath("arguments/string")[0][0]=$teamId;
            $extension->xpath("arguments/string")[1][0]=$teamName;
        }
        $phpUnit->asXML("phpunit.xml.dist");
        print "\n";
        $width = 60;
        $innerWidth = $width-2;
        print str_pad("", $width,"-",STR_PAD_BOTH)."\n";
        print "|".str_pad("",$innerWidth," ",STR_PAD_BOTH)."|\n";
        print "|".str_pad(" Your team name is : ",$innerWidth," ",STR_PAD_BOTH)."|\n";
        print "|".str_pad(" -~<[ ".$teamName." ]>~- ",$innerWidth," ",STR_PAD_BOTH)."|\n";
        print "|".str_pad("",$innerWidth," ",STR_PAD_BOTH)."|\n";
        print "|".str_pad(" (but you may change it in your phpunit.xml.dist) ",$innerWidth," ",STR_PAD_BOTH)."|\n";
        print str_pad("", $width,"-",STR_PAD_BOTH)."\n";
        print "\n";

    }

    private static function forgeTeamName(): string
    {
        $a = ["Pretty", "Awesome", "Strange", "Fluffy", "Cosmic", "Astounding", "Sparkling","Shining","Atomic","Galactic"];

        $b = ["Calamars", "Owls", "Hedgehogs", "Phoenixes", "Pixies", "Dragons","Dolphins","Firebirds","Eagles"];

        return $a[mt_rand(0, count($a) - 1)]." ".$b[mt_rand(0, count($b) - 1)];
    }
}
