<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Adapter;

use Symfony\Component\Security\Core\User\UserInterface;
use Authentication\Domain\Port\UserInterface as DomainUserInterface;

readonly class UserAdapter implements UserInterface, DomainUserInterface
{
    public function __construct(
        private DomainUserInterface $user,
    ) {
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->user->getIdentifier();
    }

    public function eraseCredentials(): void
    {
    }

    public function getIdentifier(): string
    {
        return $this->user->getIdentifier();
    }

    public function getDomainUser(): DomainUserInterface
    {
        return $this->user;
    }
}
