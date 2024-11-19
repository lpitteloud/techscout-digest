<?php

declare(strict_types=1);

namespace Authentication\Application\Service;

use Authentication\Domain\Model\User;
use Authentication\Domain\Port\GoogleAuthenticationServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class GoogleLoginService
{
    private GoogleAuthenticationServiceInterface $googleAuthService;

    public function __construct(GoogleAuthenticationServiceInterface $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function initiateGoogleLogin(): RedirectResponse
    {
        return $this->googleAuthService->getRedirectResponse();
    }

    public function handleGoogleCallback(string $code): ?User
    {
        return $this->googleAuthService->authenticateUser($code);
    }
}
