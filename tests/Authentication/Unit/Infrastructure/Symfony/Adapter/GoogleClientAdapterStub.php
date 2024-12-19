<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Port\GoogleClientInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleClientAdapterStub implements GoogleClientInterface
{
    public const string OAUTH2_REDIRECT_URI = 'https://accounts.google.com/o/oauth2/auth';

    public function __construct(
        private readonly AbstractProvider $provider,
        private bool $stateless = false,
        private readonly string $accessToken = 'fake_google_token',
        /** @var array<string,string> $googleUser */
        private readonly array $googleUser = ['sub' => 'google-123'],
    ) {
    }

    /**
     * @param array<string> $scopes
     * @param array<string> $options
     */
    public function redirect(array $scopes = [], array $options = []): RedirectResponse
    {
        return new RedirectResponse(self::OAUTH2_REDIRECT_URI);
    }

    public function getAccessToken(array $scopes = []): AccessToken
    {
        return new AccessToken([
            'access_token' => $this->accessToken,
            'expires_in' => 3600,
            'refresh_token' => 'fake_refresh_token',
            'scope' => implode(' ', $scopes),
        ]);
    }

    public function fetchUserFromToken(AccessToken $accessToken): ResourceOwnerInterface
    {
        return new GoogleUser($this->googleUser);
    }

    public function setAsStateless(): void
    {
        $this->stateless = true;
    }

    public function isStateless(): bool
    {
        return $this->stateless;
    }

    public function fetchUser(): ResourceOwnerInterface
    {
        return new GoogleUser($this->googleUser);
    }

    public function getOAuth2Provider(): AbstractProvider
    {
        return $this->provider;
    }
}
