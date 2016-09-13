<?php


class seoCest
{
    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->canSeeInTitle('Clean Code');
    }
}
