Feature: User Login with Google SSO
    In order to access my dashboard
    As a visitor
    I want to be able to log in with Google SSO

    Scenario: Successful login with Google SSO
        Given I am on the login page
        When I click "Login with Google"
        And I am redirected to Google for authentication
        And I provide valid Google credentials
        Then I should be redirected to my dashboard
        And I should see "Welcome to your dashboard"
