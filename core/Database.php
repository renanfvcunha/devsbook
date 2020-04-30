<?php

namespace core;

class Database
{
    private static $_pdo;
    public static function getInstance()
    {
        if (!isset(self::$_pdo)) {
            //MySQL
            self::$_pdo = new \PDO(
                getenv('DB_DRIVER') .
                    ":dbname=" .
                    getenv('DB_NAME') .
                    ";host=" .
                    getenv('DB_HOST') .
                    ";charset=utf8",
                getenv('DB_USER'),
                getenv('DB_PASS'),
            );

            //Postgres
            /* self::$_pdo = new \PDO(
                getenv('DB_DRIVER') . ":host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT')
                    . ";dbname=" . getenv('DB_NAME') . ";user=" . getenv('DB_USER') . ";password="
                    . getenv('DB_PASS')
            ); */
        }
        return self::$_pdo;
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }
}
