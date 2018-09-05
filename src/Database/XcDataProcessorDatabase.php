<?php
/**
 * Created by SlimApp.
 *
 * Date: 2018-09-05
 * Time: 02:10
 */

namespace Vendor\XcDataProcessor\Database;

use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Cache\RegionsConfiguration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Oasis\Mlib\ODM\Dynamodb\ItemManager;
use Oasis\Mlib\Utils\DataProviderInterface;
use Vendor\XcDataProcessor\XcDataProcessor;


class XcDataProcessorDatabase
{
    public static function getEntityManager()
    {
        static $entityManager = null;
        if ($entityManager instanceof EntityManager) {
            return $entityManager;
        }
        
        $app = XcDataProcessor::app();

        $memcache = new MemcachedCache();
        /** @noinspection PhpParamsInspection */
        $memcache->setMemcached($app->getService('memcached'));
        
        $isDevMode = $app->isDebug();
        $config    = Setup::createAnnotationMetadataConfiguration(
            [PROJECT_DIR . "/src/Entities"],
            $isDevMode,
            $app->getParameter('app.dir.data') . "/proxies",
            $memcache,
            false /* do not use simple annotation reader, so that we can understand annotations like @ORM/Table */
        );
        $config->addEntityNamespace("XcDataProcessor", "Vendor\\XcDataProcessor\\Entities");
        //$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());

        $regconfig = new RegionsConfiguration();
        $factory   = new DefaultCacheFactory($regconfig, $memcache);
        $config->setSecondLevelCacheEnabled();
        $config->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

        $conn           = $app->getParameter('app.db');
        $conn["driver"] = "pdo_mysql";
        $entityManager  = EntityManager::create($conn, $config);

        return $entityManager;
    }

    public static function getItemManager()
    {
        /** @var ItemManager $im */
        static $im = null;
        
        if ($im === null) {
            $app = XcDataProcessor::app();
            
            $cacheDir  = $app->getMandatoryConfig('dir.cache', DataProviderInterface::STRING_TYPE);
            $awsConfig = $app->getMandatoryConfig('aws', DataProviderInterface::ARRAY_TYPE);
            $prefix    = $app->getMandatoryConfig('dynamodb.prefix', DataProviderInterface::STRING_TYPE);
            
            $im = new ItemManager($awsConfig, $prefix, $cacheDir, $app->isDebug());
            $dir = PROJECT_DIR . "/src/Items";
            if (\is_dir($dir)) {
                $im->addNamespace("Vendor\\XcDataProcessor\\Items", $dir);
            }
        }
        
        return $im;
    }
}
