<?php

declare(strict_types=1);

namespace Tests\Authentication\Unit\Domain\Model;

use Authentication\Domain\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testADomainUserCanBeCreatedWithAnIdentifier(): void
    {
        $user = new User('google-id-123');

        $this->assertEquals('google-id-123', $user->getIdentifier());
    }
}
