<?php

declare(strict_types=1);

namespace Authentication\Domain\Model;

interface UserInterface
{
    public function getIdentifier(): string;
}
