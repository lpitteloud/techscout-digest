<?php

declare(strict_types=1);

namespace Tests\Authentication\Behat\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

class RedirectUnauthenticatedUserContext extends RawMinkContext
{
    /**
     * @Given I am not authenticated
     */
    public function iAmNotAuthenticated(): void
    {
        $this->getSession()->reset();
    }

    /**
     * @When I try to access :path
     */
    public function iTryToAccess(string $path): void
    {
        $this->visitPath($path);
    }

    /**
     * @Then I should be redirected to :path
     */
    public function iShouldBeRedirectedTo(string $path): void
    {
        Assert::assertStringContainsString(
            $path,
            $this->getSession()->getCurrentUrl(),
            sprintf('Expected to be redirected to %s', $path)
        );
    }
}
