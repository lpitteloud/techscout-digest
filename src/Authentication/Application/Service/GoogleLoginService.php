<?php

declare(strict_types=1);

namespace Authentication\Application\Service;

use Authentication\Domain\Model\User;
use Authentication\Domain\Port\GoogleAuthenticationServiceInterface;

final class GoogleLoginService
{
    private GoogleAuthenticationServiceInterface $googleAuthService;

    public function __construct(GoogleAuthenticationServiceInterface $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function getRedirectUrl(): string
    {
        return $this->googleAuthService->getRedirectUrl();
    }

    public function handleGoogleCallback(string $code): ?User
    {
        return $this->googleAuthService->authenticateUser($code);
    }
}
