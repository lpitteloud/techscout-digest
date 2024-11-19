<?php

declare(strict_types=1);

namespace Authentication\Domain\Port;

interface UserInterface
{
    public function getIdentifier(): string;
}
