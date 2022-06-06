<?php

namespace Akenlab\DojoExtension;

interface DojoEvent
{
    public function __serialize(): array;
}