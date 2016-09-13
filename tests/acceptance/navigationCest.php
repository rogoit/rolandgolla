<?php
use Step\Acceptance\Acceptance;

class navigationCest
{
    public function _before(Acceptance $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('.header');
    }

    //public function checkLinksToAnchor(Acceptance $I)
    //{
    //    $links = $I->grabMultiple('.header-navigation > li > a', 'href');
    //    foreach ($links as $link) {
    //        $I->assertContains('#', $link, 'Link contains #: ' . $link);
    //    }
    //}
    //
    //public function checkLogoLink(Acceptance $I)
    //{
    //    $selector = '.site-logo';
    //
    //    $href = $I->grabAttributeFrom($selector, 'href');
    //    $I->assertContains('http', $href);
    //
    //    $target = $I->grabAttributeFrom($selector, 'target');
    //    $I->assertContains('_blank', $target);
    //
    //    $title = $I->grabAttributeFrom($selector, 'title');
    //    $I->assertNotEmpty('_blank', $title);
    //}
    //
    //public function resizeNavigation(Acceptance $I)
    //{
    //    $burgerMenu = '.mobi-toggler';
    //    $headerNavigation = '.header-navigation';
    //
    //    $I->dontSeeElement($burgerMenu);
    //    $I->resizeWindow(400, 1000);
    //    $I->wait(1);
    //    $I->waitForElement($burgerMenu);
    //    $I->cantSeeElement($headerNavigation);
    //    $I->click($burgerMenu);
    //    $I->waitForElement($headerNavigation);
    //    $I->click($burgerMenu);
    //    $I->waitForElementNotVisible($headerNavigation);
    //    $I->resizeWindow(1600, 1000);
    //    $I->wait(1);
    //    $I->waitForElementNotVisible($burgerMenu);
    //}

    public function mouseOverAndClick(Acceptance $I)
    {
        $selector = '.header-navigation > li';
        $navItems = $I->grabMultiple($selector, 'class');

        // Check default setting
        $I->assertContains('current', $navItems[0]);
        for($i = 2; $i < count($navItems); $i++) {
            $I->assertEmpty($navItems[$i], 'Class is empty on item: ' . $i);

            $actualItemLi = '.header-navigation > li:nth-of-type(' . $i . ')';
            $actualItemA = $actualItemLi . ' > a';
            $colorNoMouseOver = $I->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) use ($actualItemA)
            {
                return $webdriver->findElement(WebDriverBy::cssSelector(
                    $actualItemA))->getCSSValue('color');
            });

            $I->moveMouseOver($actualItemA);

            $colorOnMouseOver = $I->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) use ($actualItemA)
            {
                return $webdriver->findElement(WebDriverBy::cssSelector(
                    $actualItemA))->getCSSValue('color');
            });

            $I->assertNotEquals($colorNoMouseOver, $colorOnMouseOver, 'Color no mouse over: ' . $colorNoMouseOver . ' color mouse over: ' . $colorOnMouseOver . ' on actualItemA: ' . $actualItemA);

            $I->click($actualItemLi);
            $I->wait(2);
            $class = $I->grabAttributeFrom($actualItemLi, 'class');
            $I->assertContains('current', $class);
        }


    }
}
