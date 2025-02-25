<?php

declare(strict_types=1);

namespace Tests\Authentication\Behat\Context;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

class UserLogoutContext extends RawMinkContext
{
    public function __construct(
        private readonly AuthenticationContext $authenticationContext,
    ) {
    }

    /**
     * @Given I am logged in
     *
     * @throws ElementNotFoundException
     */
    public function iAmLoggedIn(): void
    {
        $this->authenticationContext->iAmOnTheLoginPage();
        $this->authenticationContext->iClickLoginWithGoogle();
        $this->authenticationContext->iAmRedirectedToGoogleForAuthentication();
        $this->authenticationContext->iProvideValidGoogleCredentials();
    }

    /**
     * @Given I am on the dashboard page
     */
    public function iAmOnTheDashboardPage(): void
    {
        $this->visitPath('/dashboard');
    }

    /**
     * @When I click the "Log out" button
     *
     * @throws ElementNotFoundException
     */
    public function iClickTheLogoutButton(): void
    {
        $this->getSession()->getPage()->clickLink('Log out');
    }

    /**
     * @Then I should be redirected to the login page
     */
    public function iShouldBeRedirectedToTheLoginPage(): void
    {
        Assert::assertStringContainsString('/login', $this->getSession()->getCurrentUrl());
    }

    /**
     * @Then I should not have access to dashboard anymore
     */
    public function andIShouldNotHaveAccessAnActiveSession(): void
    {
        $this->visitPath('/dashboard');
        Assert::assertStringContainsString('/login', $this->getSession()->getCurrentUrl());
    }
}
