<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Model\User;
use Authentication\Infrastructure\Symfony\Adapter\UserAdapter;
use PHPUnit\Framework\TestCase;

class UserAdapterTest extends TestCase
{
    public function testAdapterCorrectlyTransformsDomainUser(): void
    {
        $domainUser = new User('google-id-123');
        $userAdapter = new UserAdapter($domainUser);

        $this->assertEquals(['ROLE_USER'], $userAdapter->getRoles());
        $this->assertEquals('google-id-123', $userAdapter->getUserIdentifier());
        $this->assertSame($domainUser, $userAdapter->getDomainUser());
    }
}
