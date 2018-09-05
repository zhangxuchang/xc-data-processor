<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */

use Vendor\XcDataProcessor\XcDataProcessor;
use Monolog\Logger;
use Oasis\Mlib\Logging\ConsoleHandler;
use Oasis\Mlib\Logging\MLogging;

/** @var XcDataProcessor $app */
$app = require __DIR__ . "/../bootstrap.php";
if (!$app->isDebug()) {
    die ("Never run unit test under production environment!");
}

(new ConsoleHandler())->install();
if (!in_array('-v', $_SERVER['argv'])
    && !in_array('--verbose', $_SERVER['argv'])
) {
    MLogging::setMinLogLevel(Logger::CRITICAL);
}


        
$console = $app->getConsoleApplication();

/** @var Symfony\Component\Console\Helper\HelperSet $helperSet */
$helperSet = require_once __DIR__ . "/../config/cli-config.php";
$console->setHelperSet($helperSet);
\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($console);

$output = new \Symfony\Component\Console\Output\ConsoleOutput();
$console->setAutoExit(false);
$console->setCatchExceptions(false);
$console->setLoggingEnabled(false);
$console->run(
    new \Symfony\Component\Console\Input\ArrayInput(
        [
            "command" => "orm:schema-tool:drop",
            "-f"      => true,
            "-vvv"    => true,
        ]
    ),
    $output
);
$console->run(
    new \Symfony\Component\Console\Input\ArrayInput(
        [
            "command" => "orm:schema-tool:create",
        ]
    ),
    $output
);


return $app;
