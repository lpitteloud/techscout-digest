<?php

declare(strict_types=1);

namespace Tests\Authentication\Behat\Context;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;
use Tests\Authentication\Unit\Infrastructure\Symfony\Adapter\GoogleClientAdapterStub;

class UserLoginContext extends RawMinkContext
{
    /**
     * @Given I am on the login page
     */
    public function iAmOnTheLoginPage(): void
    {
        $this->visitPath('/login');
    }

    /**
     * @When I click "Login with Google"
     *
     * @throws ElementNotFoundException
     */
    public function iClickLoginWithGoogle(): void
    {
        $this->getSession()->getPage()->clickLink('Login with Google');
    }

    /**
     * @When I am redirected to Google for authentication
     */
    public function iAmRedirectedToGoogleForAuthentication(): void
    {
        $currentUrl = $this->getSession()->getCurrentUrl();

        Assert::assertStringContainsString(
            GoogleClientAdapterStub::OAUTH2_REDIRECT_URI,
            $currentUrl,
            'Expected to be redirected to OAuth provider'
        );
    }

    /**
     * @When I provide valid Google credentials
     */
    public function iProvideValidGoogleCredentials(): void
    {
        $callbackUrl = '/login/google/callback';

        $queryParams = [
            'code' => 'fake_authorization_code',
            'state' => $this->getSession()->getCookie('oauth2state'),
        ];

        $callbackUrlWithParams = sprintf('%s?%s', $callbackUrl, http_build_query($queryParams));

        $this->visitPath($callbackUrlWithParams);
    }

    /**
     * @Then I should be redirected to my dashboard
     */
    public function iShouldBeRedirectedToMyDashboard(): void
    {
        Assert::assertStringContainsString('/dashboard', $this->getSession()->getCurrentUrl());
    }
}
