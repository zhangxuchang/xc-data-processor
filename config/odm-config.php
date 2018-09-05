<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */
use Oasis\Mlib\ODM\Dynamodb\Console\ConsoleHelper;
use Vendor\XcDataProcessor\Database\XcDataProcessorDatabase;

require_once __DIR__ . '/../bootstrap.php';

$itemManager = XcDataProcessorDatabase::getItemManager();

return new ConsoleHelper($itemManager);

