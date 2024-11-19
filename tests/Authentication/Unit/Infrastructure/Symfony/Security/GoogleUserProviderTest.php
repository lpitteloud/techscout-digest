<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Security;

use Authentication\Domain\Model\User;
use Authentication\Infrastructure\Symfony\Adapter\UserAdapter;
use Authentication\Infrastructure\Symfony\Security\GoogleUserProvider;
use PHPUnit\Framework\TestCase;

class GoogleUserProviderTest extends TestCase
{
    private GoogleUserProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new GoogleUserProvider();
    }

    public function testLoadUserByIdentifier(): void
    {
        $identifier = 'google-id-123';
        $user = $this->provider->loadUserByIdentifier($identifier);

        $this->assertEquals($identifier, $user->getUserIdentifier());
        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    public function testSupportsClass(): void
    {
        $this->assertTrue($this->provider->supportsClass(UserAdapter::class));
        $this->assertFalse($this->provider->supportsClass(\stdClass::class));
    }

    public function testRefreshUser(): void
    {
        $user = new UserAdapter(new User('google-id-123'));
        $refreshedUser = $this->provider->refreshUser($user);

        $this->assertSame('google-id-123', $refreshedUser->getIdentifier());
    }
}
