<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Model\User;
use Authentication\Domain\Port\GoogleClientInterface;
use Authentication\Infrastructure\Symfony\Adapter\GoogleAuthenticationAdapter;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleAuthenticationAdapterTest extends TestCase
{
    public function testGetAuthorizationUrl(): void
    {
        $expectedUrl = 'https://accounts.google.com/o/oauth2/auth';
        $googleClient = $this->createMock(GoogleClientInterface::class);
        $googleClient->expects($this->once())
            ->method('redirect')
            ->with(['email', 'profile'], [])
            ->willReturn(new RedirectResponse($expectedUrl));

        $adapter = new GoogleAuthenticationAdapter($googleClient);
        $authorizationUrl = $adapter->getRedirectResponse();

        $this->assertStringStartsWith($expectedUrl, $authorizationUrl->getTargetUrl());
    }

    public function testAuthenticateUser(): void
    {
        $googleClient = $this->createMock(GoogleClientInterface::class);
        $googleToken = $this->createMock(AccessToken::class);
        $googleUser = $this->createMock(GoogleUser::class);

        $googleClient
            ->expects($this->once())
            ->method('getAccessToken')
            ->with(['code' => 'test_code'])
            ->willReturn($googleToken);

        $googleClient
            ->expects($this->once())
            ->method('fetchUserFromToken')
            ->with($googleToken)
            ->willReturn($googleUser);

        $googleUser
            ->expects($this->once())
            ->method('getId')
            ->willReturn('google_id_123');

        $adapter = new GoogleAuthenticationAdapter($googleClient);
        $user = $adapter->authenticateUser('test_code');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('google_id_123', $user->getIdentifier());
    }
}
