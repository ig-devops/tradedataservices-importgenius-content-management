Feature: Landing Page Removal Tool
    As an Employee.
    I want to be able to Remove Landing Pages.

    Scenario: Removing a Landing Page.
        Given I have a Landing Page.
            And the Landing Page is in the list of Published Landing Pages.
        When I Remove the Landing Page.
        Then the Landing Page is Marked As Private.
            And the Landing Page is Permanently Black Listed.
            And the Landing Page should be removed from the list of Published Landing Pages.
            And all the Events are recorded in the Audit Trail.
