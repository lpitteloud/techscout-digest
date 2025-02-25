<?php

declare(strict_types=1);

namespace Tests\Authentication\Behat\Context;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\When;
use PHPUnit\Framework\Assert;
use Tests\Authentication\Unit\Infrastructure\Symfony\Adapter\GoogleClientAdapterStub;

class AuthenticationContext extends RawMinkContext
{
    #[Given('I am on the login page')]
    public function iAmOnTheLoginPage(): void
    {
        $this->visitPath('/login');
    }

    /**
     * @throws ElementNotFoundException
     */
    #[When('I click "Login with Google"')]
    public function iClickLoginWithGoogle(): void
    {
        $this->getSession()->getPage()->clickLink('Login with Google');
    }

    #[When('I am redirected to Google for authentication')]
    public function iAmRedirectedToGoogleForAuthentication(): void
    {
        $currentUrl = $this->getSession()->getCurrentUrl();

        Assert::assertStringContainsString(
            GoogleClientAdapterStub::OAUTH2_REDIRECT_URI,
            $currentUrl,
            'Expected to be redirected to OAuth provider'
        );
    }

    #[When('I provide valid Google credentials')]
    public function iProvideValidGoogleCredentials(): void
    {
        $callbackUrl = '/login/google/callback';

        $queryParams = [
            'code' => 'fake_authorization_code',
        ];

        $callbackUrlWithParams = sprintf('%s?%s', $callbackUrl, http_build_query($queryParams));

        $this->visitPath($callbackUrlWithParams);
    }
}
