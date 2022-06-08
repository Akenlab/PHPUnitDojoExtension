<?php

namespace Akenlab\DojoExtension;

class DojoAgent
{

    private DojoAgentDriver $driver;
    private string $teamId;

    private static ?DojoAgent $_instance=null;
    private int $failuresCount=0;
    private int $successCount=0;
    private string $teamName;

    public static function instance(DojoAgentDriver $driver,string $teamId,string $teamName){
        if(!self::$_instance){
            self::$_instance=new self($driver,$teamId,$teamName);
        }
        return self::$_instance;
    }
    public static function destroy(){
        if(self::$_instance){
            self::$_instance=null;
        }
    }

    private function __construct(DojoAgentDriver $driver,string $teamId,string $teamName)
    {
        $this->driver = $driver;
        $this->teamId = $teamId;
        $this->teamName = $teamName;
    }

    public function dispatch(DojoEvent $event)
    {
        //We don't want the driver to block anything in case of a problem...
        try{
            $this->driver->dispatch($event);
        }catch (\Exception $e){
            //...so we just ignore any exception occuring
        }
    }

    public function teamId()
    {
        return $this->teamId;
    }

    public function failuresCount()
    {
        return $this->failuresCount;
    }

    public function addFailure()
    {
        $this->failuresCount++;
    }

    public function successCount()
    {
        return $this->successCount;
    }

    public function addSuccess()
    {
        $this->successCount++;
    }


    public function teamName(): string
    {
        return $this->teamName;
    }
}