<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Port\GoogleClientInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleClientAdapterStub implements GoogleClientInterface
{
    public const string OAUTH2_REDIRECT_URI = 'https://accounts.google.com/o/oauth2/auth';

    /**
     * @var array<string,string>
     */
    private array $googleUser = [
        'sub' => 'google-123',
    ];

    private string $accessToken = 'fake_google_token';

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
}
