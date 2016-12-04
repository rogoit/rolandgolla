<?php
use Step\Acceptance\Acceptance;

class seoCest
{
    // tests
    public function testTitle(Acceptance $I)
    {
        $I->amOnPage('/');
        $I->canSeeInTitle('Clean Code');
    }
}
