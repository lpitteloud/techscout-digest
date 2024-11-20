<?php

declare(strict_types=1);

namespace Authentication\Domain\Model;

readonly class User implements UserInterface
{
    public function __construct(
        private string $googleId,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->googleId;
    }
}
