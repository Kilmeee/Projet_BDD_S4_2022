<?php

namespace gamepedia\db;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{

    protected static Capsule $capsule;

    /**
     * Static method to connect to the database
     * @param $file string config file
     * @param $withQueryLog bool if true, queries will be logged. false as default
     */
    public static function start(string $file, bool $withQueryLog = false)
    {
        self::$capsule = new Capsule;
        if (!file_exists($file)) {
            print_r("Config file not found");
            exit();
        }
        $config = parse_ini_file($file);
        self::$capsule->addConnection(array('driver' => $config['db_driver'],
                'host' => $config['db_host'],
                'database' => $config['db_name'],
                'username' => $config['db_user'],
                'password' => $config['db_password'],
                'charset' => $config['db_charset'],
                'collation' => $config['db_collation'],
                'prefix' => $config['db_prefix'])
        );
        self::$capsule->setAsGlobal();
        self::$capsule->bootEloquent();
        if ($withQueryLog) {
            self::$capsule->getConnection()->enableQueryLog();
        }
        try {
            self::$capsule->getConnection()->getPdo();
        } catch (Exception $e) {
            print_r($e->getMessage());
            print_r("\nCould not connect to the database");
            exit();
        }
    }

    public static function getQueryLog(): array
    {
        return self::$capsule->getConnection()->getQueryLog();
    }
}