Feature: Redirect unauthenticated user
    In order to protect sensitive areas of the site
    As a security system
    I need to ensure unauthenticated users are redirected to login

    Scenario: Unauthenticated user tries to access protected page
        Given I am not authenticated
        When I try to access "/dashboard"
        Then I should be redirected to "/login"
        And I should see "Login with Google"
