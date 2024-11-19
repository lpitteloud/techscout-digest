<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Security;

use Authentication\Infrastructure\Symfony\Adapter\UserAdapter;
use Authentication\Infrastructure\Symfony\Security\GoogleAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class GoogleAuthenticatorTest extends TestCase
{
    public function testGeneratesAValidUserAdapter(): void
    {
        $clientRegistryMock = $this->createMock(ClientRegistry::class);
        $googleClientMock = $this->createMock(OAuth2ClientInterface::class);
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

        $clientRegistryMock
            ->method('getClient')
            ->willReturn($googleClientMock);

        $authenticator = new GoogleAuthenticator($clientRegistryMock, $routerMock);

        $passport = $authenticator->authenticate($this->createMock(Request::class));
        $userAdapter = $passport->getUser();

        $this->assertInstanceOf(UserAdapter::class, $userAdapter);
        $this->assertEquals('google-id-123', $userAdapter->getUserIdentifier());
    }
}
