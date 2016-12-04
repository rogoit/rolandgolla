<?php
namespace Helper;

class Acceptance extends \Codeception\Module
{
    public function overwriteConfigByEnv() {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../../');
        $dotenv->overload();

        $webDriver = $this->getModule('WebDriver');
        $webDriver->_reconfigure(
            [
                'url' => getenv('URL')
            ]
        );
    }
}
