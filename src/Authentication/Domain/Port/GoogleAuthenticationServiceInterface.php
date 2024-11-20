<?php

declare(strict_types=1);

namespace Authentication\Domain\Port;

use Authentication\Domain\Model\User;

interface GoogleAuthenticationServiceInterface
{
    public function getRedirectUrl(): string;

    public function authenticateUser(string $code): ?User;
}
