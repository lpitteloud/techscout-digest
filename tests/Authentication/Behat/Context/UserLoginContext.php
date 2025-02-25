<?php

declare(strict_types=1);

namespace Tests\Authentication\Behat\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;

class UserLoginContext extends RawMinkContext
{
    #[Then('I should be redirected to my dashboard')]
    public function iShouldBeRedirectedToMyDashboard(): void
    {
        Assert::assertStringContainsString('/dashboard', $this->getSession()->getCurrentUrl());
    }
}
