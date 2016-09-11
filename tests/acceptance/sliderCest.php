<?php


class sliderCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h2');
    }

    public function sliderHasElements(AcceptanceTester $I)
    {
        $I->seeNumberOfElements('.tp-banner > ul > li', [1,5]);
    }

    public function sliderHasArrows(AcceptanceTester $I)
    {
        $firstItem = '.tp-banner > ul > li:nth-of-type(1)';
        $I->moveMouseOver($firstItem);
        $I->seeNumberOfElements('#slider-block > div > div.tparrows', 2);
    }

    public function bgImageisUnique(AcceptanceTester $I)
    {
        $bgImages = $aLinks = $I->grabMultiple('.tp-banner > ul > li > div.slotholder > div.tp-bgimg', 'src');
        foreach ($bgImages as $bgImage) {
            if(count(array_keys($bgImages, $bgImage)) > 1) {
                $I->assertTrue(false, 'BG image is not unique: ', $bgImage);
            }
        }
    }

    public function noMouseAutomateSlide(AcceptanceTester $I)
    {
        $I->reloadPage();
        $styles = $I->grabAttributeFrom('.tp-banner > ul > li:nth-of-type(1)', 'style');
        $I->assertContains('visibility: inherit; opacity: 1;', $styles);
        $I->waitForElementVisible('.tp-banner > ul > li:nth-of-type(2)', 15);

        // wait for animation fade
        $I->wait(2);
        $styles = $I->grabAttributeFrom('.tp-banner > ul > li:nth-of-type(1)', 'style');
        $I->assertContains('visibility: hidden; opacity: 0;', $styles);
    }

    public function onMouseOverStopSlide(AcceptanceTester $I)
    {
        $firstItem = '.tp-banner > ul > li:nth-of-type(1)';

        $I->reloadPage();
        $I->moveMouseOver($firstItem);
        $styles = $I->grabAttributeFrom($firstItem, 'style');
        $I->wait(10);
        $I->assertContains('visibility: inherit; opacity: 1;', $styles);
        $I->moveMouseOver('body > div.header.header-mobi-ext > div');
        $I->waitForElementVisible('.tp-banner > ul > li:nth-of-type(2)');
    }
}
