<?php

namespace Akenlab\DojoExtension;

interface DojoAgentDriver
{
    public function dispatch(DojoEvent $event): void;
}