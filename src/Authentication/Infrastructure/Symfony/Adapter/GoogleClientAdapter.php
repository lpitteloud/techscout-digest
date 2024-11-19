<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Adapter;

use Authentication\Domain\Port\GoogleClientInterface;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

readonly class GoogleClientAdapter implements OAuth2ClientInterface, GoogleClientInterface
{
    public function __construct(
        private GoogleClient $client,
    ) {
    }

    /**
     * @param array<string>        $scopes
     * @param array<string,string> $options
     *
     * @return RedirectResponse
     */
    public function redirect(array $scopes, array $options = [])
    {
        return $this->client->redirect($scopes, $options);
    }

    /**
     * @param array<string,string> $options
     *
     * @return AccessTokenInterface
     *
     * @throws IdentityProviderException
     */
    public function getAccessToken(array $options = [])
    {
        return $this->client->getAccessToken($options);
    }

    /**
     * @return ResourceOwnerInterface
     */
    public function fetchUserFromToken(AccessToken $accessToken)
    {
        return $this->client->fetchUserFromToken($accessToken);
    }

    /**
     * @return void
     */
    public function setAsStateless()
    {
        $this->client->setAsStateless();
    }

    public function fetchUser()
    {
        return $this->client->fetchUser();
    }

    public function getOAuth2Provider()
    {
        return $this->client->getOAuth2Provider();
    }
}
