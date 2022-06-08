<?php

namespace Akenlab\DojoExtension\Events;

use Akenlab\DojoExtension\DojoEvent;
use Ramsey\Uuid\Uuid;


class TestRunnerStarted implements DojoEvent
{
    private string $teamId;
    private string $id;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $teamId)
    {
        $this->createdAt=new \DateTimeImmutable();
        $this->id=Uuid::uuid4()->toString();
        $this->teamId = $teamId;
    }

    public function teamId()
    {
        return $this->teamId;
    }

    public function id(){
        return $this->id;
    }
    public function __serialize(): array
    {
        return [
            "id"=>$this->id,
            "teamId"=>$this->teamId,
            "createtAt"=>$this->createdAt->format(\DateTimeInterface::ISO8601)
        ];
    }
}