<?php

namespace Akenlab\DojoExtension\Events;

use Akenlab\DojoExtension\DojoEvent;
use Ramsey\Uuid\Uuid;


class TestsWereRun implements DojoEvent
{
    private string $teamId;
    private string $id;
    private int $successCount;
    private int $failuresCount;
    private \DateTimeImmutable $createdAt;
    private string $teamName;

    public function __construct(string $teamId,string $teamName,int $successes,int $failures)
    {
        $this->createdAt=new \DateTimeImmutable();
        $this->id=Uuid::uuid4()->toString();
        $this->teamId = $teamId;
        $this->successCount=$successes;
        $this->failuresCount=$failures;
        $this->teamName = $teamName;
    }

    public function teamId()
    {
        return $this->teamId;
    }

    public function successCount()
    {
        return $this->successCount;
    }

    public function teamName()
    {
        return $this->teamName;
    }

    public function failuresCount()
    {
        return $this->failuresCount;
    }

    public function id(){
        return $this->id;
    }
    public function __serialize(): array
    {
        return [
            "id"=>$this->id,
            "teamId"=>$this->teamId,
            "teamName"=>$this->teamName,
            "successes"=>$this->successCount,
            "failures"=>$this->failuresCount,
            "createdAt"=>$this->createdAt->format(\DateTimeInterface::ISO8601)
        ];
    }
}