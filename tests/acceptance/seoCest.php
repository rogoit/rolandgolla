<?php


class seoCest
{
    // tests
    public function testTitle(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->canSeeInTitle('Clean Code');
    }
}
