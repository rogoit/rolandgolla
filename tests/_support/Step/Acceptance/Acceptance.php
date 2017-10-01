<?php
namespace Step\Acceptance;

use Codeception\Scenario;

class Acceptance extends \AcceptanceTester
{
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
        $this->overwriteConfigByEnv();
    }

}