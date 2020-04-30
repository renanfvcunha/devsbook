<?php

namespace src;

class Config
{
    const BASE_DIR = '/';

    const DB_DRIVER = 'mysql';
    const DB_HOST = '172.20.0.2';
    const DB_PORT = 3306;
    const DB_NAME = 'devsbook';
    const DB_USER = 'root';
    const DB_PASS = 'docker';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}
