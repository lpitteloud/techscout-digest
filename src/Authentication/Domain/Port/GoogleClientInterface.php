<?php

declare(strict_types=1);

namespace Authentication\Domain\Port;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface GoogleClientInterface
{
    /**
     * @param array<string>        $scopes
     * @param array<string,string> $options
     *
     * @return RedirectResponse
     */
    public function redirect(array $scopes, array $options = []);

    /**
     * @param array<string> $scopes
     *
     * @return AccessToken
     */
    public function getAccessToken(array $scopes = []);

    /**
     * @return ResourceOwnerInterface
     */
    public function fetchUserFromToken(AccessToken $accessToken);
}
