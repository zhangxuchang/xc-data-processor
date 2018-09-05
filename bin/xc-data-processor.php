#! /usr/bin/env php
<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */


use Vendor\XcDataProcessor\XcDataProcessor;

/** @var XcDataProcessor $app */
$app = require_once __DIR__ . "/../bootstrap.php";

$app->getConsoleApplication()->run();

