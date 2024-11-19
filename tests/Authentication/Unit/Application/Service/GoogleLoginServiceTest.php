<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Application\Service;

use Authentication\Application\Service\GoogleLoginService;
use Authentication\Domain\Model\User;
use Authentication\Domain\Port\GoogleAuthenticationServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleLoginServiceTest extends TestCase
{
    /**
     * @var GoogleAuthenticationServiceInterface&MockObject
     */
    private GoogleAuthenticationServiceInterface $googleAuthenticationService;

    private GoogleLoginService $loginService;

    public function setUp(): void
    {
        $this->googleAuthenticationService = $this->createMock(GoogleAuthenticationServiceInterface::class);
        $this->loginService = new GoogleLoginService($this->googleAuthenticationService);
    }

    public function testInitiateGoogleLoginReturnsAuthUrl(): void
    {
        $expectedUrl = 'https://accounts.google.com/o/oauth2/auth';
        $expectedResponse = new RedirectResponse($expectedUrl);

        $this->googleAuthenticationService
            ->expects($this->once())
            ->method('getRedirectResponse')
            ->willReturn($expectedResponse);

        $result = $this->loginService->initiateGoogleLogin();

        $this->assertEquals($expectedUrl, $result->getTargetUrl());
    }

    public function testHandleGoogleCallbackReturnsUser(): void
    {
        $code = 'test_code';
        $expectedUser = new User('google_id_123');

        $this->googleAuthenticationService
            ->expects($this->once())
            ->method('authenticateUser')
            ->with($code)
            ->willReturn($expectedUser);

        $result = $this->loginService->handleGoogleCallback($code);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($expectedUser, $result);
    }
}
