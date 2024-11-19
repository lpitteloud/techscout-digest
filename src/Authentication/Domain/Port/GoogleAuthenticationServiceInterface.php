<?php

declare(strict_types=1);

namespace Authentication\Domain\Port;

use Authentication\Domain\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface GoogleAuthenticationServiceInterface
{
    public function getRedirectResponse(): RedirectResponse;

    public function authenticateUser(string $code): ?User;
}
