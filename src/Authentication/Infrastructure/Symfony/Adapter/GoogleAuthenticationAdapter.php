<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Port\GoogleClientInterface;
use Authentication\Domain\Model\User;
use Authentication\Domain\Port\GoogleAuthenticationServiceInterface;

use function PHPUnit\Framework\assertIsString;

readonly class GoogleAuthenticationAdapter implements GoogleAuthenticationServiceInterface
{
    public function __construct(
        private GoogleClientInterface $googleClient,
    ) {
    }

    public function getRedirectUrl(): string
    {
        return $this->googleClient->redirect(['email', 'profile'])->getTargetUrl();
    }

    public function authenticateUser(string $code): ?User
    {
        $token = $this->googleClient->getAccessToken([
            'code' => $code,
        ]);

        $googleUser = $this->googleClient->fetchUserFromToken($token);
        $googleUserId = $googleUser->getId();

        assertIsString($googleUserId);

        return new User(
            $googleUserId
        );
    }
}
