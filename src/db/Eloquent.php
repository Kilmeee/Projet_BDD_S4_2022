<?php

namespace gamepedia\db;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{

    /**
     * Static method to connect to the database
     * @param $file string config file
     */
    public static function start(string $file)
    {
        $capsule = new Capsule;
        if (!file_exists($file)) {
            print_r("Config file not found");
            exit();
        }
        $config = parse_ini_file($file);
        $capsule->addConnection(array('driver' => $config['db_driver'],
                'host' => $config['db_host'],
                'database' => $config['db_name'],
                'username' => $config['db_user'],
                'password' => $config['db_password'],
                'charset' => $config['db_charset'],
                'collation' => $config['db_collation'],
                'prefix' => $config['db_prefix'])
        );
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        try {
            $capsule->getConnection()->getPdo();
        } catch (Exception $e) {
            print_r($e->getMessage());
            print_r("\nCould not connect to the database");
            exit();
        }
    }
}