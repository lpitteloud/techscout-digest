<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Security;

use Authentication\Domain\Port\GoogleClientInterface;
use Authentication\Infrastructure\Symfony\Adapter\UserAdapter;
use Authentication\Infrastructure\Symfony\Security\GoogleAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class GoogleAuthenticatorTest extends TestCase
{
    public function testGeneratesAValidUserAdapter(): void
    {
        $googleClientMock = $this->createMock(GoogleClientInterface::class);
        $routerMock = $this->createMock(RouterInterface::class);

        $googleClientMock
            ->expects($this->once())
            ->method('fetchUserFromToken')
            ->willReturn(new GoogleUser([
                'sub' => 'google-id-123',
            ]));

        $googleClientMock
            ->expects($this->once())
            ->method('getAccessToken')
            ->willReturn(new AccessToken(['access_token' => 'mocked_access_token']));

        $authenticator = new GoogleAuthenticator($googleClientMock, $routerMock);

        $passport = $authenticator->authenticate($this->createMock(Request::class));
        $userAdapter = $passport->getUser();

        $this->assertInstanceOf(UserAdapter::class, $userAdapter);
        $this->assertEquals('google-id-123', $userAdapter->getUserIdentifier());
    }
}
