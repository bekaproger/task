<?php

namespace Lil\Db;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DbFactory
{
    private static $manager;

    public static function createEntityManager()
    {
        if (!self::$manager) {
            self::$manager = EntityManager::create(self::getDatabaseConnectionConfig(), self::getAnnotationConfig());
        }

        return self::$manager;
    }

    private static function getDatabaseConnectionConfig()
    {
        return config('database.connections')[env('DB_DRIVER')];
    }

    private static function getAnnotationConfig()
    {
        $configs = config('doctrine');

        return Setup::createAnnotationMetadataConfiguration(
            [app()->getBaseDir().'/app/Model'],
            $configs['dev_mode'],
            $configs['proxy_dir'],
            $configs['cache'],
            false);
    }
}
