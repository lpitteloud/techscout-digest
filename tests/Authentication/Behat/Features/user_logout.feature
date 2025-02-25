Feature: Logout
    As a logged-in user
    I want to be able to log out
    So that I can secure my account

    Scenario: Successful Logout
        Given I am logged in
        And I am on the dashboard page
        When I click the "Log out" button
        Then I should be redirected to the login page
        And I should not have access to dashboard anymore
