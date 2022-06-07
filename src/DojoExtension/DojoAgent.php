<?php

namespace Akenlab\DojoExtension;

class DojoAgent
{

    private DojoAgentDriver $driver;
    private string $teamId;

    private static ?DojoAgent $_instance=null;
    private int $failuresCount=0;
    private int $successCount=0;

    public static function instance(DojoAgentDriver $driver,string $teamId){
        if(!self::$_instance){
            self::$_instance=new self($driver,$teamId);
        }
        return self::$_instance;
    }
    public static function destroy(){
        if(self::$_instance){
            self::$_instance=null;
        }
    }

    private function __construct(DojoAgentDriver $driver,string $teamId)
    {
        $this->driver = $driver;
        $this->teamId = $teamId;
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
}