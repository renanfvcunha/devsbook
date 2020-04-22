<?php

namespace core;

use src\Config;

class Database
{
    private static $_pdo;
    public static function getInstance()
    {
        if (!isset(self::$_pdo)) {
            //MySQL
            self::$_pdo = new \PDO(
                Config::DB_DRIVER .
                    ":dbname=" .
                    Config::DB_NAME .
                    ";host=" .
                    Config::DB_HOST .
                    ";charset=utf8",
                Config::DB_USER,
                Config::DB_PASS,
            );

            //Postgres
            /* self::$_pdo = new \PDO(
                Config::DB_DRIVER . ":host=" . Config::DB_HOST . ";port=" . Config::DB_PORT
                    . ";dbname=" . Config::DB_NAME . ";user=" . Config::DB_USER . ";password="
                    . Config::DB_PASS
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
