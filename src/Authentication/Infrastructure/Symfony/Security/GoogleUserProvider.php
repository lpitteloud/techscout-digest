<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Security;

use Authentication\Domain\Model\User;
use Authentication\Infrastructure\Symfony\Adapter\UserAdapter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements UserProviderInterface<UserAdapter>
 */
class GoogleUserProvider implements UserProviderInterface
{
    public function loadUserByIdentifier(string $identifier): UserAdapter
    {
        return new UserAdapter(new User($identifier));
    }

    public function supportsClass(string $class): bool
    {
        return UserAdapter::class === $class;
    }

    public function refreshUser(UserInterface $user): UserAdapter
    {
        return new UserAdapter(new User($user->getUserIdentifier()));
    }
}
