Feature: Privacy Request
    As an Employee.
    In order to attend to Privacy Requests.
    I want to be able to mark Landing Pages as Private.

    Scenario: Marking a Landing Page as Private.
        Given I have a Landing Page.
            And the Landing Page is in the list of Published Landing Pages.
        When I mark a Landing Page as Private.
        Then the Landing Page is Marked As Private.
            And all the Events are recorded in the Audit Trail.

