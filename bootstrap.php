<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */

use Vendor\XcDataProcessor\XcDataProcessor;
use Vendor\XcDataProcessor\XcDataProcessorConfiguration;

require_once __DIR__ . "/vendor/autoload.php";

define('PROJECT_DIR', __DIR__);

/** @var XcDataProcessor $app */
$app = XcDataProcessor::app();
$app->init(__DIR__ . "/config", new XcDataProcessorConfiguration(), __DIR__ . "/cache/config");

return $app;

