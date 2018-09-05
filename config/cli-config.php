<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */
 
 
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Vendor\XcDataProcessor\Database\XcDataProcessorDatabase;

require_once __DIR__ . "/../bootstrap.php";

return ConsoleRunner::createHelperSet(XcDataProcessorDatabase::getEntityManager());
